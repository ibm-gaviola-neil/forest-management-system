/**
 * Map Viewer - Reusable map display component
 * 
 * This function initializes a read-only map view with a marker
 * at the specified coordinates. It's designed to be reused across
 * the application for displaying location information.
 * 
 * @param {string} containerId - The ID of the HTML element to contain the map
 * @param {number|string} latitude - The latitude coordinate
 * @param {number|string} longitude - The longitude coordinate
 * @param {string} popupText - Optional text to display in the marker popup
 * @param {number} zoom - Optional zoom level (default: 18)
 * @returns {Object} The Leaflet map instance
 */
export function initMapViewer(containerId, latitude, longitude, popupText = 'Location', zoom = 18) {
    // Convert string coordinates to numbers if needed
    const lat = typeof latitude === 'string' ? parseFloat(latitude) : latitude;
    const lng = typeof longitude === 'string' ? parseFloat(longitude) : longitude;
    
    // Get the container element
    const container = document.getElementById(containerId);
    if (!container) {
      console.error(`Map container with ID '${containerId}' not found.`);
      return null;
    }
    
    // Initialize the map
    const viewerMap = L.map(containerId, {
      zoomControl: true,
      scrollWheelZoom: false, // Disable scroll wheel zoom for better page UX
      dragging: true,
      minZoom: 3,
      maxZoom: 22
    }).setView([lat, lng], zoom);
    
    // Add base layers
    const baseMaps = {};
    
    // OpenStreetMap layer
    const openStreetMap = L.tileLayer(
      "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19,
      }
    );
    baseMaps["Street Map"] = openStreetMap;
    
    // ESRI World Imagery (satellite view - excellent for seeing trees)
    const esriWorldImagery = L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
      {
        attribution: "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
        maxZoom: 22,
      }
    );
    baseMaps["Satellite"] = esriWorldImagery;
    
    // Google Maps layer (if you have the plugin)
    if (typeof L.tileLayer.provider === 'function') {
      const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ["mt0", "mt1", "mt2", "mt3"]
      });
      baseMaps["Google Streets"] = googleStreets;
      
      const googleSatellite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ["mt0", "mt1", "mt2", "mt3"]
      });
      baseMaps["Google Satellite"] = googleSatellite;
    }
    
    // Add the satellite imagery by default - best for seeing trees
    esriWorldImagery.addTo(viewerMap);
    
    // Add layer control
    L.control.layers(baseMaps, null, { position: "topright" }).addTo(viewerMap);
    
    // Create a custom tree icon
    const treeIcon = L.icon({
      iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png",
      shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41],
    });
    
    // Add a marker at the specified position
    const marker = L.marker([lat, lng], { icon: treeIcon })
      .addTo(viewerMap)
      .bindPopup(popupText)
      .openPopup();
    
    // Force a map redraw after a short delay to fix rendering issues
    setTimeout(() => {
      viewerMap.invalidateSize();
    }, 300);
    
    // Return the map instance for potential further customization
    return viewerMap;
  }
  
  // Make the function available globally
  window.initMapViewer = initMapViewer;
  
  // Export the function for ES modules
  export default initMapViewer;