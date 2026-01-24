import { displayTreesOnMap } from "../../domain/fullmap.js";

async function getTreeCoordinates ({endpoint}, query = {}) {
    const params = new URLSearchParams({ ...query }).toString();

    try {
        const response = await fetch(`${endpoint}?${params}`);
        const result = await response.json();

        return result;
    } catch (error) {
        console.error("Error fetching tree coordinates:", error);
        throw error;
    }
}

// Add this CSS for marker clusters
const style = document.createElement('style');
style.textContent = `
  .custom-cluster-icon {
    background-color: rgba(76, 175, 80, 0.6);
    border: 2px solid #4CAF50;
    border-radius: 50%;
    color: white;
    font-weight: bold;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tree-popup {
    padding: 5px;
  }
  .tree-popup strong {
    display: block;
    margin-bottom: 5px;
    color: #2d5e2d;
  }
  .tree-popup p {
    margin: 2px 0;
    font-size: 0.9em;
  }
`;
document.head.appendChild(style);

// Async function to fetch and display trees
async function fetchAndDisplayTrees(containerId) {
  try {
    // Show loading state
    const container = document.getElementById(containerId);
    container.innerHTML = '<div class="flex items-center justify-center h-full bg-gray-100 text-gray-500">Loading tree locations...</div>';
    
    // Fetch the coordinates
    const treeCoordinates = await getTreeCoordinates({
      endpoint: '/admin/trees/coordinates'
    });
    
    // Display on map
    const mapResult = displayTreesOnMap({
      containerId: containerId,
      coordinates: treeCoordinates,
      onMarkerClick: (tree, marker, index) => {
        console.log('Tree clicked:', tree);
      }
    });
    
    return mapResult;
  } catch (error) {
    console.error('Failed to display trees on map:', error);
    const container = document.getElementById(containerId);
    container.innerHTML = '<div class="flex items-center justify-center h-full bg-gray-100 text-red-500">Failed to load tree locations</div>';
  }
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", async function() {
  // Create the map container if it doesn't exist
  if (!document.getElementById('tree-map-container')) {
    const mapContainer = document.createElement('div');
    mapContainer.id = 'tree-map-container';
    mapContainer.className = 'w-full h-[600px] rounded-lg border border-gray-200 shadow-md';
    
    // Find a suitable container to append to
    const contentArea = document.querySelector('.content-area') || document.body;
    contentArea.appendChild(mapContainer);
  }
  
  // Fetch and display trees
  await fetchAndDisplayTrees('view-map-container');
});