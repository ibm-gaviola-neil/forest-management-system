/**
 * Display multiple tree coordinates on a map with status-based icons
 *
 * @param {Object} options - Configuration options
 * @param {string} options.containerId - ID of the HTML element to contain the map
 * @param {Array} options.coordinates - Array of coordinate objects with lattitude and longitude
 * @param {Object} [options.mapOptions] - Optional Leaflet map configuration options
 * @param {boolean} [options.cluster=true] - Whether to cluster markers when zoomed out
 * @param {Function} [options.onMarkerClick] - Callback function when marker is clicked
 * @param {Object} [options.customIcons] - Custom icons for markers
 * @returns {Object} The Leaflet map instance and marker array
 */
export function displayTreesOnMap(options) {
    // Default options
    const defaults = {
        containerId: "map-container",
        coordinates: [],
        mapOptions: {
            zoom: 14,
            maxZoom: 22,
            minZoom: 3,
        },
        cluster: true,
        customIcons: null,
    };

    // Merge provided options with defaults
    const config = { ...defaults, ...options };

    // Get the container element
    const container = document.getElementById(config.containerId);
    if (!container) {
        console.error(
            `Map container with ID '${config.containerId}' not found.`
        );
        return null;
    }

    // Ensure container has a height
    if (!container.style.height) {
        container.style.height = "500px";
    }

    // Check if we have coordinates
    if (!config.coordinates || config.coordinates.length === 0) {
        container.innerHTML =
            '<div class="flex items-center justify-center h-full bg-gray-100 text-gray-500">No tree location data available</div>';
        return null;
    }

    try {
        // Create different tree icons based on status
        const treeIcons = {
            // Default icon (green for registered/approved trees - status 1)
            default:
                config.customIcons?.default ||
                L.icon({
                    iconUrl:
                        "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png",
                    shadowUrl:
                        "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                }),

            // Red icon for trees marked for cutting (status 4)
            forCutting:
                config.customIcons?.forCutting ||
                L.icon({
                    iconUrl:
                        "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png",
                    shadowUrl:
                        "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                }),

            // Black icon for already cut trees (status 5)
            cut:
                config.customIcons?.cut ||
                L.icon({
                    iconUrl:
                        "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png",
                    shadowUrl:
                        "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                }),

            // Blue icon for other statuses (pending, rejected, etc.)
            other:
                config.customIcons?.other ||
                L.icon({
                    iconUrl:
                        "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png",
                    shadowUrl:
                        "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                }),
        };

        // Helper function to get appropriate icon based on tree status
        function getTreeIcon(status) {
            if (status === 1) return treeIcons.default; // Approved/registered
            if (status === 4) return treeIcons.forCutting; // For cutting
            if (status === 5) return treeIcons.cut; // Already cut
            return treeIcons.other; // Other statuses
        }

        // Helper function to get status text
        function getStatusText(status) {
            const statusMap = {
                0: "Pending",
                1: "Approved",
                2: "Rejected",
                3: "Cancelled",
                4: "For Cutting",
                5: "Cut",
            };
            return statusMap[status] || "Unknown";
        }

        // Initialize map with centered position based on first coordinate or average position
        const initialPosition = getAveragePosition(config.coordinates);
        const treeMap = L.map(config.containerId, {
            zoomControl: true,
            scrollWheelZoom: true,
            ...config.mapOptions,
        }).setView(
            [initialPosition.lat, initialPosition.lng],
            config.mapOptions.zoom
        );

        // Add base layers
        const baseMaps = {};

        // OpenStreetMap layer
        try {
            const openStreetMap = L.tileLayer(
                "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                {
                    attribution:
                        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    maxZoom: 19,
                }
            );
            baseMaps["Street Map"] = openStreetMap;
        } catch (e) {
            console.warn("Could not load OpenStreetMap layer:", e);
        }

        // ESRI World Imagery (satellite view)
        try {
            const esriWorldImagery = L.tileLayer(
                "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
                {
                    attribution:
                        "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
                    maxZoom: 22,
                }
            );
            baseMaps["Satellite"] = esriWorldImagery;

            // Add the satellite imagery by default
            esriWorldImagery.addTo(treeMap);
        } catch (e) {
            console.warn("Could not load ESRI World Imagery layer:", e);
        }

        // --- NEW MAP LAYERS ---
        // Only try to add these if we successfully added the basic layers
        if (Object.keys(baseMaps).length > 0) {
            try {
                // Topographic map
                const openTopoMap = L.tileLayer(
                    "https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",
                    {
                        attribution:
                            'Map &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 17,
                    }
                );
                baseMaps["Topographic"] = openTopoMap;
            } catch (e) {
                console.warn("Could not load Topographic layer:", e);
            }

            // Add layer control
            L.control
                .layers(baseMaps, null, { position: "topright" })
                .addTo(treeMap);
        }

        // Create markers
        const markers = [];
        let markerLayer;

        // Track counts for different statuses
        const statusCounts = {
            approved: 0,
            forCutting: 0,
            cut: 0,
            other: 0,
        };

        // Determine whether to use clustering
        if (config.cluster && typeof L.markerClusterGroup === "function") {
            try {
                // Create a marker cluster group
                markerLayer = L.markerClusterGroup({
                    showCoverageOnHover: false,
                    maxClusterRadius: 40,
                    iconCreateFunction: function (cluster) {
                        const count = cluster.getChildCount();
                        return L.divIcon({
                            html: `<div class="cluster-marker">${count}</div>`,
                            className: "custom-cluster-icon",
                            iconSize: L.point(40, 40),
                        });
                    },
                });
            } catch (e) {
                console.warn("Error creating cluster group:", e);
                markerLayer = L.layerGroup();
            }
        } else {
            // Just use a regular layer group
            markerLayer = L.layerGroup();
        }

        // Add markers for each coordinate
        config.coordinates.forEach((coord, index) => {
            try {
                // Skip invalid coordinates
                if (!coord.lattitude || !coord.longitude) {
                    console.warn(
                        `Invalid coordinates at index ${index}`,
                        coord
                    );
                    return;
                }

                const lat = parseFloat(coord.lattitude);
                const lng = parseFloat(coord.longitude);

                // Skip if lat/lng can't be parsed to numbers
                if (isNaN(lat) || isNaN(lng)) {
                    console.warn(
                        `Non-numeric coordinates at index ${index}`,
                        coord
                    );
                    return;
                }

                // Update status counts
                if (coord.status === 1) statusCounts.approved++;
                else if (coord.status === 4) statusCounts.forCutting++;
                else if (coord.status === 5) statusCounts.cut++;
                else statusCounts.other++;

                // Get the appropriate icon based on status
                const icon = getTreeIcon(coord.status);

                // Create marker with status-specific icon
                const marker = L.marker([lat, lng], {
                    icon: icon,
                    title: `Tree #${index + 1} (${getStatusText(
                        coord.status
                    )})`,
                });

                // Add popup with information including status
                const popupContent = `<div class="tree-popup">
          <strong>${
              coord.treeId ? `Tree ID: ${coord.treeId}` : `Tree #${index + 1}`
          }</strong>
          ${coord.treeType ? `<p>Type: ${coord.treeType}</p>` : ""}
          <p>Status: <span class="status-badge status-${
              coord.status
          }">${getStatusText(coord.status)}</span></p>
          <p>Latitude: ${lat.toFixed(6)}</p>
          <p>Longitude: ${lng.toFixed(6)}</p>
          </div>`;

                marker.bindPopup(popupContent);

                // Add click handler if provided
                if (config.onMarkerClick) {
                    marker.on("click", (e) =>
                        config.onMarkerClick(coord, marker, index)
                    );
                }

                // Store marker and add to layer
                markers.push(marker);
                markerLayer.addLayer(marker);
            } catch (e) {
                console.warn(
                    `Error creating marker for coordinate ${index}:`,
                    e
                );
            }
        });

        // Add the marker layer to the map
        treeMap.addLayer(markerLayer);

        // Auto fit the map to show all markers if we have multiple markers
        if (markers.length > 1) {
            try {
                const group = new L.featureGroup(markers);
                treeMap.fitBounds(group.getBounds().pad(0.1)); // Add 10% padding
            } catch (e) {
                console.warn("Error fitting bounds:", e);
            }
        }

        // Add scale control
        try {
            L.control
                .scale({
                    imperial: false,
                    position: "bottomleft",
                })
                .addTo(treeMap);
        } catch (e) {
            console.warn("Error adding scale control:", e);
        }

        // Add fullscreen control if available
        if (typeof L.control.fullscreen === "function") {
            try {
                L.control
                    .fullscreen({
                        position: "topleft",
                        title: "Show fullscreen",
                        titleCancel: "Exit fullscreen",
                        forceSeparateButton: true,
                    })
                    .addTo(treeMap);
            } catch (e) {
                console.warn("Error adding fullscreen control:", e);
            }
        }

        // Add measure tool if available
        if (typeof L.Control.Measure === "function") {
            try {
                const measureControl = new L.Control.Measure({
                    position: "topleft",
                    primaryLengthUnit: "meters",
                    secondaryLengthUnit: "kilometers",
                    primaryAreaUnit: "sqmeters",
                    secondaryAreaUnit: "hectares",
                });
                measureControl.addTo(treeMap);
            } catch (e) {
                console.warn("Error adding measure control:", e);
            }
        }

        // Add locate control if available
        if (typeof L.control.locate === "function") {
            try {
                L.control
                    .locate({
                        position: "topleft",
                        strings: {
                            title: "Find my location",
                        },
                        locateOptions: {
                            enableHighAccuracy: true,
                        },
                    })
                    .addTo(treeMap);
            } catch (e) {
                console.warn("Error adding locate control:", e);
            }
        }

        // Add legend to show what each marker color means
        try {
            const legend = L.control({ position: "bottomright" });
            legend.onAdd = function (map) {
                const div = L.DomUtil.create("div", "info legend");
                div.innerHTML = `
          <div class="bg-white p-3 rounded shadow-md">
            <div class="text-sm font-semibold mb-2">Tree Legend</div>
            <div class="space-y-2">
              ${
                  statusCounts.approved > 0
                      ? `
                <div class="flex items-center">
                  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png" alt="Registered tree" class="w-3 h-5 mr-2">
                  <span class="text-xs">Registered (${statusCounts.approved})</span>
                </div>`
                      : ""
              }
              ${
                  statusCounts.forCutting > 0
                      ? `
                <div class="flex items-center">
                  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png" alt="For cutting" class="w-3 h-5 mr-2">
                  <span class="text-xs">For Cutting (${statusCounts.forCutting})</span>
                </div>`
                      : ""
              }
              ${
                  statusCounts.cut > 0
                      ? `
                <div class="flex items-center">
                  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png" alt="Cut tree" class="w-3 h-5 mr-2">
                  <span class="text-xs">Cut (${statusCounts.cut})</span>
                </div>`
                      : ""
              }
              ${
                  statusCounts.other > 0
                      ? `
                <div class="flex items-center">
                  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png" alt="Other status" class="w-3 h-5 mr-2">
                  <span class="text-xs">Other (${statusCounts.other})</span>
                </div>`
                      : ""
              }
              <div class="text-xs text-gray-600 mt-1">Total: ${
                  markers.length
              } tree(s)</div>
            </div>
          </div>
        `;
                return div;
            };
            legend.addTo(treeMap);
        } catch (e) {
            console.warn("Error adding legend:", e);
        }

        // Add CSS for status badges in popups
        const style = document.createElement("style");
        style.textContent = `
      .status-badge {
        padding: 2px 6px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
      }
      .status-badge.status-0 { background-color: #FEF3C7; color: #92400E; } /* Pending - yellow */
      .status-badge.status-1 { background-color: #D1FAE5; color: #065F46; } /* Approved - green */
      .status-badge.status-2 { background-color: #FEE2E2; color: #B91C1C; } /* Rejected - red */
      .status-badge.status-3 { background-color: #E5E7EB; color: #374151; } /* Cancelled - gray */
      .status-badge.status-4 { background-color: #FECACA; color: #991B1B; } /* For Cutting - dark red */
      .status-badge.status-5 { background-color: #1F2937; color: #F9FAFB; } /* Cut - black */
    `;
        document.head.appendChild(style);

        // Force a map redraw
        // Force a map redraw
        setTimeout(() => {
            treeMap.invalidateSize();
        }, 300);

        // Return the map and markers
        return {
            map: treeMap,
            markers: markers,
            markerLayer: markerLayer,
        };
    } catch (error) {
        console.error("Error initializing map:", error);
        container.innerHTML =
            '<div class="flex items-center justify-center h-full bg-gray-100 text-red-500">Error initializing map</div>';
        return null;
    }

    // Helper function to calculate average position
    function getAveragePosition(coordinates) {
        if (!coordinates || coordinates.length === 0) {
            return { lat: 0, lng: 0 };
        }

        let validCoords = coordinates.filter(
            (coord) =>
                coord.lattitude &&
                coord.longitude &&
                !isNaN(parseFloat(coord.lattitude)) &&
                !isNaN(parseFloat(coord.longitude))
        );

        if (validCoords.length === 0) {
            return { lat: 0, lng: 0 };
        }

        const sum = validCoords.reduce(
            (acc, coord) => {
                return {
                    lat: acc.lat + parseFloat(coord.lattitude),
                    lng: acc.lng + parseFloat(coord.longitude),
                };
            },
            { lat: 0, lng: 0 }
        );

        return {
            lat: sum.lat / validCoords.length,
            lng: sum.lng / validCoords.length,
        };
    }
}
