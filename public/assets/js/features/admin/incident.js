import initMapViewer from "../../domain/map-view.js";
import { submitForm } from "../../services/formService.js";
import { redirectModal, showSuccessAlert } from "../../ui/alert.js";
import { buttonLoader } from "../../ui/html-ui.js";
import { getIncidentStatusBadge, getIncidentTypeBadge, renderPaginatedTable } from "../../ui/table-loader.js";

const createForm = document.getElementById('incidentForm');
const viewMapSection = document.getElementById("view-map-section");
const incidentEditForm = document.getElementById('incidentEditForm');
const applyFilter = document.getElementById('apply-filters');
const resetFilter = document.getElementById('reset-filters');

let currentSearch = ""
let statusSearch = ""
let filterStatus = ""
let start_date = ""
let end_date = ""

if (createForm) {
    createForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const loginBtn = document.getElementById('submit-btn');
        const loading = buttonLoader(' Loading...');
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;
        
        try {
            const response = await submitForm({
                url: '/admin/incidents/store',
                formData,
                buttonId: 'submit-btn',
                errorDisplayId: 'errorDiv',
            });
            
            loginBtn.innerHTML = `Submit Incident`;
            
            // Show the standard success alert that you already have
            showSuccessAlert('Incident reported successfully. Redirecting', 'success');
            
            // Create a success confirmation popup
            redirectModal(
                'Incident reported successfully.',
                '/admin/incidents'
            );
            
        } catch (error) {
            showSuccessAlert('Something went wrong, please try again.', 'error');
            loginBtn.innerHTML = `Submit Incident`;
        }
    });
}

if (incidentEditForm) {
  incidentEditForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const chainsawId = document.getElementById("incident_id");
        const loginBtn = document.getElementById("submit-btn");
        const loading = buttonLoader(" Loading...");
        const formData = new FormData(e.target);
        loginBtn.innerHTML = `${loading}`;

        try {
            const response = await submitForm({
                url: `/admin/incidents/update/${chainsawId.value}`,
                formData,
                buttonId: "submit-btn",
                errorDisplayId: "errorDiv",
            });
            loginBtn.innerHTML = `Update Incident`;
            showSuccessAlert('Incident information update successfully. Redirecting', 'success');
            
            // Create a success confirmation popup
            redirectModal(
                'Incident updated successfully.',
                `/admin/incidents/${chainsawId.value}`
            );
        } catch (error) {
            console.log(error);
            loginBtn.innerHTML = `Update Incident`;
        }
    });
}

function buildIncidentRow(incident) {
  return `
      <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${incident.id || ""}</td>
          <td class="px-6 py-4 whitespace-nowrap">${getIncidentTypeBadge(incident.incident_type || incident.type)}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${incident.location || ""}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${incident.reporter_name || ""}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${incident.report_date || incident.incident_date || ""}</td>
          <td class="px-6 py-4 whitespace-nowrap">${getIncidentStatusBadge(incident.status)}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="/admin/incidents/${incident.id}" class="text-green-600 hover:text-green-900 mr-3">
                  <i class="fas fa-eye"></i> View
              </a>
          </td>
      </tr>
  `;
}

function loadTreeTable(page = 1) {
    const query = {};
    if (currentSearch) query.search = currentSearch;
    if (statusSearch) query.status = statusSearch;
    if (filterStatus) query.type = filterStatus;
    if (start_date) query.start_date = start_date;
    if (end_date) query.end_date = end_date;

    renderPaginatedTable({
        tbodyId: "incidentTable",
        paginationId: "treeTablePagination",
        endpoint: "/admin/incidents/list",
        page,
        buildRowFn: buildIncidentRow,
        columns: 7,
        query,
        paginationBgColor: 'green'
    });
}

function search() {
  const statusSearchInput = document.getElementById('status-filter');
  const typeSearchInput = document.getElementById('type-filter');
  const stardDate = document.getElementById('date-from');
  const endDate = document.getElementById('date-to');
  
  statusSearch = statusSearchInput.value ?? "";
  filterStatus = typeSearchInput.value ?? "";
  start_date = stardDate.value ?? "";
  end_date = endDate.value ?? "";

  loadTreeTable(1);
}

function resetSearch() {
  const statusSearchInput = document.getElementById('status-filter');
  const typeSearchInput = document.getElementById('type-filter');
  const stardDate = document.getElementById('date-from');
  const endDate = document.getElementById('date-to');

  statusSearchInput.value  = "";
  typeSearchInput.value  = "";
  stardDate.value  = "";
  endDate.value =  "";
  
  statusSearch = "";
  filterStatus =  "";
  start_date = "";
  end_date = "";

  loadTreeTable(1);
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

  if(applyFilter) {
    applyFilter.addEventListener('click', search)
  }

  if(resetFilter) {
    resetFilter.addEventListener('click', resetSearch)
  }
});
