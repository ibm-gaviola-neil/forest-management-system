import initMapViewer from "../domain/map-view.js";
import { submitForm, submitPlainPost } from "../services/formService.js";
import { closeModal, showSuccessAlert } from "../ui/alert.js";
import { buttonLoader, loader } from "../ui/html-ui.js";
import {
    debounce,
    getStatusBadge,
    renderPaginatedTable,
} from "../ui/table-loader.js";

const loginForm = document.getElementById("treeForm");
const editForm = document.getElementById("editTreeForm");
const cancelBtn = document.getElementById("cancel-btn");
const treeSearch = document.getElementById("treeSearch");
const statusSearchId = document.getElementById("status-search");
const viewMapSection = document.getElementById("view-map-section");

let currentSearch = "";
let statusSearch = 0; // To keep track of the current page

if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const loginBtn = document.getElementById("submit-btn");
        const loading = buttonLoader(" Loading...");
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;

        try {
            const response = await submitForm({
                url: "/applicant/trees/store",
                formData,
                buttonId: "submit-btn",
                errorDisplayId: "loginResponse",
            });
            loginBtn.innerHTML = `Submit`;
            alert("Tree registered successfully!");
            window.location.replace("/applicant/trees");
        } catch (error) {
            console.log(error);
            loginBtn.innerHTML = `Submit`;
        }
    });
}

if (editForm) {
    editForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const treeId = document.getElementById("tree-id");
        const loginBtn = document.getElementById("submit-btn");
        const loading = buttonLoader(" Loading...");
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;

        try {
            const response = await submitForm({
                url: `/applicant/trees/update/${treeId.value}`,
                formData,
                buttonId: "submit-btn",
                errorDisplayId: "loginResponse",
            });
            loginBtn.innerHTML = `Submit`;
            alert("Tree updated successfully!");
            window.location.replace(`/applicant/trees/view/${treeId.value}`);
        } catch (error) {
            console.log(error);
            loginBtn.innerHTML = `Update`;
        }
    });
}

if (cancelBtn) {
    cancelBtn.addEventListener("click", async () => {
        const treeId = cancelBtn.value;
        const loading = buttonLoader(" Loading...");
        cancelBtn.innerHTML = loading;

        try {
            const data = await submitPlainPost({
                url: "/applicant/trees/cancel/" + treeId,
            });

            if (data.status == 200) {
                closeModal();
                cancelBtn.innerHTML = "Yes, Cancel";
                showSuccessAlert("Tree registration cancelled successfuly!");
                document.getElementById(
                    "status-badge"
                ).innerHTML = `<h2 class="text-3xl font-bold text-center">Tree Information</h2> ${getStatusBadge(
                    3
                )}`;
            } else {
                cancelBtn.innerHTML = "Yes, Cancel";
                showSuccessAlert(data.message, "error");
            }
        } catch (error) {
            console.log(error);

            cancelBtn.innerHTML = "Yes, Cancel";
            showSuccessAlert("Server error, please try again!", "error");
        }
    });
}

function buildTreeRow(tree) {
    return `
      <tr>
        <td class="px-4 py-4 border-b border-gray-200">${tree.treeId || ""}</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.treeType || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.datePlanted || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.height || ""
        }m / ${tree.diameter || ""}cm</td>
        <td class="px-4 py-4 border-b border-gray-200">${
            tree.location || ""
        }</td>
        <td class="px-4 py-4 border-b border-gray-200">${getStatusBadge(
            tree.status
        )}</td>
        <td class="px-4 py-4 border-b border-gray-200">
          <div class="flex gap-2">
            <a href="/applicant/trees/view/${
                tree.id
            }" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs font-semibold">View</a>
          </div>
        </td>
      </tr>
    `;
}

function loadTreeTable(page = 1) {
    const query = {};
    if (currentSearch) query.search = currentSearch;
    if (statusSearch) query.status = statusSearch;

    renderPaginatedTable({
        tbodyId: "treeTable",
        paginationId: "treeTablePagination",
        endpoint: "/applicant/trees/trees-list",
        page,
        buildRowFn: buildTreeRow,
        columns: 7,
        query,
    });
}

function setMapView() {
    // Make sure the container exists
    const mapContainer = document.getElementById("map-container");
    const locationInput = document.getElementById("location-input");
    if (!mapContainer) {
      console.error("Map container not found!");
      return;
    }
    
    // Set a fixed height to ensure visibility
    mapContainer.style.height = "400px"; // Increased height for better visibility
    console.log("Initializing map...");
    
    // Check for existing coordinates in form fields
    const latField = document.getElementById("latitude");
    const lngField = document.getElementById("longitude");
    const latDisplay = document.getElementById("lat-display") || document.createElement("span");
    const lngDisplay = document.getElementById("lng-display") || document.createElement("span");
    const statusEl = document.getElementById("location-status") || document.createElement("div");
    
    // Get initial position - use existing coordinates if available, otherwise default to Jakarta
    let initialLat = -6.2; // Default Jakarta, Indonesia
    let initialLng = 106.816666;
    let hasExistingLocation = false;
    
    // Check if we have valid coordinates in the form
    if (latField && lngField && 
        latField.value && lngField.value && 
        !isNaN(parseFloat(latField.value)) && 
        !isNaN(parseFloat(lngField.value))) {
      
      initialLat = parseFloat(latField.value);
      initialLng = parseFloat(lngField.value);
      hasExistingLocation = true;
      console.log("Using existing coordinates:", initialLat, initialLng);
      
      // Update display fields
      if (latDisplay) latDisplay.textContent = initialLat;
      if (lngDisplay) lngDisplay.textContent = initialLng;
    }
    
    const defaultPosition = [initialLat, initialLng]; 
    const defaultZoom = 18; // Higher zoom level (18-20) is good for seeing individual trees
    
    // Initialize map with default or existing center
    const registrationMap = L.map("map-container", {
      zoomControl: true,
      minZoom: 3,
      maxZoom: 22, // Allow high zoom levels
    }).setView(defaultPosition, defaultZoom);
    
    console.log("Map initialized, adding layers...");
    
    // Create base layers - multiple options for better tree visibility
    const openStreetMap = L.tileLayer(
      "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19,
      }
    );
    
    // ESRI World Imagery (satellite view - excellent for seeing trees)
    const esriWorldImagery = L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
      {
        attribution: "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
        maxZoom: 22,
      }
    );
    
    // Open Topo Map (shows terrain which can be helpful)
    const openTopoMap = L.tileLayer(
      "https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",
      {
        attribution: 'Map &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a>',
        maxZoom: 17,
      }
    );
    
    // Google Maps layer (if you add the appropriate plugin)
    const googleStreets = L.tileLayer(
      "http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}",
      {
        maxZoom: 20,
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
      }
    );
    
    const googleSatellite = L.tileLayer(
      "http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
      {
        maxZoom: 20,
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
      }
    );
    
    // Create a layer group for all base maps
    const baseMaps = {
      "Street Map": openStreetMap,
      Satellite: esriWorldImagery,
      Topographic: openTopoMap,
      "Google Streets": googleStreets,
      "Google Satellite": googleSatellite,
    };
    
    // Add the satellite imagery by default - best for seeing trees
    esriWorldImagery.addTo(registrationMap);
    
    // Add layer control to switch between different map types
    L.control
      .layers(baseMaps, null, { position: "topright" })
      .addTo(registrationMap);
    
    // Create a custom tree icon
    const treeIcon = L.icon({
      iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png",
      shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41],
    });
    
    // Variables
    let marker;
    
    // Function to update marker and form fields
    function updateMarkerAndFields(latlng) {
      // Remove previous marker if exists
      if (marker) {
        registrationMap.removeLayer(marker);
      }
      
      // Add marker at specified position with custom tree icon
      marker = L.marker(latlng, { icon: treeIcon })
        .addTo(registrationMap)
        .bindPopup("Tree location")
        .openPopup();
      
      // Update form fields and displays
      const lat = latlng.lat.toFixed(6); // More precision
      const lng = latlng.lng.toFixed(6);
      
      if (latField) latField.value = lat;
      if (lngField) lngField.value = lng;
      if (latDisplay) latDisplay.textContent = lat;
      if (lngDisplay) lngDisplay.textContent = lng;
      
      // Update status if the element exists
      if (statusEl) {
        statusEl.textContent = "Tree location selected";
        statusEl.classList.remove(
          "hidden",
          "bg-yellow-100",
          "text-yellow-800",
          "bg-blue-100",
          "text-blue-800"
        );
        statusEl.classList.add("bg-green-100", "text-green-800");
      }
      
      // Try to get address for this location
      getAddressFromCoordinates(latlng.lat, latlng.lng);
    }
    
    // Reverse geocoding - get address from coordinates
    function getAddressFromCoordinates(lat, lng) {
      fetch(
        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`
      )
        .then((response) => response.json())
        .then((data) => {
          if (data && data.display_name) {
            // Create or find an element to display the address
            let addressEl = document.getElementById("location-address");
            if (!addressEl) {
              addressEl = document.createElement("div");
              addressEl.id = "location-address";
              addressEl.className = "mt-2 text-xs text-gray-600 break-words";
              if (statusEl && statusEl.parentNode) {
                statusEl.parentNode.appendChild(addressEl);
              }
            }
            addressEl.textContent = data.display_name;
            if (locationInput) locationInput.value = data.display_name;
          }
        })
        .catch((err) => {
          console.error("Error getting address:", err);
          // In case of error, set the coordinates as the location
          if (locationInput) locationInput.value = `${lat}, ${lng}`;
        });
    }
    
    // If we have existing coordinates, add a marker immediately
    if (hasExistingLocation) {
      const existingLocation = L.latLng(initialLat, initialLng);
      updateMarkerAndFields(existingLocation);
      
      if (statusEl) {
        statusEl.textContent = "Existing tree location loaded";
        statusEl.classList.remove("hidden", "bg-yellow-100", "text-yellow-800");
        statusEl.classList.add("bg-green-100", "text-green-800");
      }
    }
    // If no existing coordinates and geolocation is available, try to get user's position
    else if (navigator.geolocation) {
      console.log("Getting current position...");
      
      if (statusEl) {
        statusEl.textContent = "Getting your location...";
        statusEl.classList.remove("hidden");
        statusEl.classList.add("bg-blue-100", "text-blue-800");
      }
      
      navigator.geolocation.getCurrentPosition(
        function (position) {
          const userLocation = L.latLng(
            position.coords.latitude,
            position.coords.longitude
          );
          console.log("Got user location:", userLocation);
          registrationMap.setView(userLocation, 19); // Zoom level 19-20 shows individual trees clearly
          updateMarkerAndFields(userLocation);
        },
        function (error) {
          console.warn("Geolocation error:", error.message);
          if (statusEl) {
            statusEl.textContent = "Click on the map to select tree location";
            statusEl.classList.remove("bg-blue-100", "text-blue-800");
            statusEl.classList.add("bg-yellow-100", "text-yellow-800");
          }
        },
        {
          enableHighAccuracy: true,
          timeout: 7000,
          maximumAge: 0,
        }
      );
    }
    
    // Add click event to place a marker
    registrationMap.on("click", function (e) {
      console.log("Map clicked at:", e.latlng);
      updateMarkerAndFields(e.latlng);
    });
    
    // Force a map redraw after a short delay
    setTimeout(() => {
      console.log("Invalidating map size...");
      registrationMap.invalidateSize();
    }, 300);
    
    // Add location finder button
    if (typeof L.control.locate === "function") {
      try {
        L.control
          .locate({
            position: "topleft",
            strings: {
              title: "Find my current location",
            },
            locateOptions: {
              enableHighAccuracy: true,
              maxZoom: 19,
            },
            flyTo: true,
            onLocationError: function (err) {
              console.error("Location error:", err.message);
            },
            onLocationFound: function (e) {
              updateMarkerAndFields(e.latlng);
            },
          })
          .addTo(registrationMap);
        console.log("Locate control added");
      } catch (e) {
        console.error("Error adding locate control:", e);
      }
    }
    
    // Add search functionality (requires Leaflet Control Geocoder plugin)
    if (typeof L.Control.Geocoder !== "undefined") {
      L.Control.geocoder({
        defaultMarkGeocode: false,
        position: "topleft",
        placeholder: "Search for location...",
        errorMessage: "Location not found",
      })
        .on("markgeocode", function (e) {
          const bbox = e.geocode.bbox;
          const poly = L.polygon([
            bbox.getSouthEast(),
            bbox.getNorthEast(),
            bbox.getNorthWest(),
            bbox.getSouthWest(),
          ]);
          registrationMap.fitBounds(poly.getBounds());
          updateMarkerAndFields(e.geocode.center);
        })
        .addTo(registrationMap);
    }
    
    return registrationMap;
}

const debouncedSearch = debounce(function (e) {
    currentSearch = e.target.value;
    loadTreeTable(1);
}, 400);

if (treeSearch) {
    treeSearch.addEventListener("input", debouncedSearch);
}

if (statusSearchId) {
    statusSearchId.addEventListener("change", function (e) {
        statusSearch = e.target.value;
        loadTreeTable(1);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    loadTreeTable();
    setTimeout(() => {
        const map = setMapView();

        // Force a redraw again after a second to make extra sure
        setTimeout(() => {
            if (map) map.invalidateSize();
        }, 1000);
    }, 100);

    if (viewMapSection) {
      const mapLatitude = document.getElementById("map-latitude");
      const mapLongitude = document.getElementById("map-longitude");
      initMapViewer('view-map-container', mapLatitude.value, mapLongitude.value, 'Tree Location', 18);
    }
});
