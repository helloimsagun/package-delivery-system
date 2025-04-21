// class Graph {
//     constructor() {
//         this.nodes = new Map();
//     }

//     addNode(id, lat, lon) {
//         this.nodes.set(id, { lat, lon, edges: [] });
//     }

//     addEdge(startId, endId, weight) {
//         this.nodes.get(startId).edges.push({ node: endId, weight });
//         this.nodes.get(endId).edges.push({ node: startId, weight });
//     }

//     findShortestPath(startId, endId) {
//         const distances = new Map();
//         const previousNodes = new Map();
//         const unvisitedNodes = new Set(this.nodes.keys());
//         const infinity = Number.MAX_SAFE_INTEGER;
//         const shortestPath = [];

//         for (let nodeId of this.nodes.keys()) {
//             distances.set(nodeId, infinity);
//         }
//         distances.set(startId, 0);

//         while (unvisitedNodes.size) {
//             let currentNodeId = Array.from(unvisitedNodes).reduce((minNode, node) => 
//                 distances.get(node) < distances.get(minNode) ? node : minNode
//             );

//             if (distances.get(currentNodeId) === infinity) break;

//             unvisitedNodes.delete(currentNodeId);

//             if (currentNodeId === endId) {
//                 let tempNodeId = endId;
//                 while (previousNodes.has(tempNodeId)) {
//                     shortestPath.unshift(tempNodeId);
//                     tempNodeId = previousNodes.get(tempNodeId);
//                 }
//                 shortestPath.unshift(startId);
//                 return shortestPath;
//             }

//             for (let edge of this.nodes.get(currentNodeId).edges) {
//                 let alt = distances.get(currentNodeId) + edge.weight;
//                 if (alt < distances.get(edge.node)) {
//                     distances.set(edge.node, alt);
//                     previousNodes.set(edge.node, currentNodeId);
//                 }
//             }
//         }

//         return [];
//     }

//     getNodeCoordinates(nodeId) {
//         const node = this.nodes.get(nodeId);
//         return node ? [node.lat, node.lon] : null;
//     }
// }

// // Distance calculation utility function
// function calculateDistance(lat1, lon1, lat2, lon2) {
//     const R = 6371; // Radius of the Earth in kilometers
//     const dLat = deg2rad(lat2 - lat1); // Convert latitude difference to radians
//     const dLon = deg2rad(lon2 - lon1); // Convert longitude difference to radians
//     const a = 
//         Math.sin(dLat / 2) * Math.sin(dLat / 2) +
//         Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
//         Math.sin(dLon / 2) * Math.sin(dLon / 2); 
//     const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)); 
//     return R * c; // Distance in kilometers
// }

// // Helper function to convert degrees to radians
// function deg2rad(deg) {
//     return deg * (Math.PI / 180);
// }