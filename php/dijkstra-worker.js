class Graph {
    constructor() {
        this.nodes = new Map();
        this.edges = new Map();
    }

    addNode(id, lat, lon) {
        this.nodes.set(id, { lat, lon });
    }

    addEdge(startId, endId, weight) {
        if (!this.edges.has(startId)) this.edges.set(startId, new Map());
        if (!this.edges.has(endId)) this.edges.set(endId, new Map());
        this.edges.get(startId).set(endId, weight);
        this.edges.get(endId).set(startId, weight);
    }
}

// Implement A* algorithm for faster pathfinding
function findShortestPath(graph, startId, endId) {
    const open = new Set([startId]);
    const cameFrom = new Map();
    const gScore = new Map([[startId, 0]]);
    const fScore = new Map([[startId, heuristic(graph, startId, endId)]]);

    while (open.size > 0) {
        const current = [...open].reduce((a, b) => fScore.get(a) < fScore.get(b) ? a : b);

        if (current === endId) {
            return reconstructPath(cameFrom, current);
        }

        open.delete(current);

        for (const [neighbor, weight] of (graph.edges.get(current) || [])) {
            const tentativeGScore = gScore.get(current) + weight;

            if (!gScore.has(neighbor) || tentativeGScore < gScore.get(neighbor)) {
                cameFrom.set(neighbor, current);
                gScore.set(neighbor, tentativeGScore);
                fScore.set(neighbor, gScore.get(neighbor) + heuristic(graph, neighbor, endId));
                open.add(neighbor);
            }
        }
    }

    return null; // No path found
}

function heuristic(graph, nodeId, goalId) {
    const nodeCoords = graph.nodes.get(nodeId);
    const goalCoords = graph.nodes.get(goalId);
    return Math.sqrt(
        Math.pow(nodeCoords.lat - goalCoords.lat, 2) +
        Math.pow(nodeCoords.lon - goalCoords.lon, 2)
    );
}

function reconstructPath(cameFrom, current) {
    const path = [current];
    while (cameFrom.has(current)) {
        current = cameFrom.get(current);
        path.unshift(current);
    }
    return path;
}

let graph;

self.onmessage = function(e) {
    if (e.data.command === 'createGraph') {
        console.time('Graph Creation');
        graph = new Graph();
        const waypoints = e.data.waypoints;

        // Only add nodes that are part of ways
        const relevantNodes = new Set();
        waypoints.elements.forEach(element => {
            if (element.type === 'way' && element.tags && element.tags.highway) {
                element.nodes.forEach(nodeId => relevantNodes.add(nodeId));
            }
        });

        waypoints.elements.forEach(element => {
            if (element.type === 'node' && relevantNodes.has(element.id)) {
                graph.addNode(element.id, element.lat, element.lon);
            } else if (element.type === 'way' && element.tags && element.tags.highway) {
                for (let i = 0; i < element.nodes.length - 1; i++) {
                    const startNode = graph.nodes.get(element.nodes[i]);
                    const endNode = graph.nodes.get(element.nodes[i + 1]);
                    if (startNode && endNode) {
                        const weight = calculateDistance(startNode.lat, startNode.lon, endNode.lat, endNode.lon);
                        graph.addEdge(element.nodes[i], element.nodes[i + 1], weight);
                    }
                }
            }
        });

        console.timeEnd('Graph Creation');
        self.postMessage({ command: 'graphCreated', nodeCount: graph.nodes.size });
    } else if (e.data.command === 'findPath') {
        console.time('Path Finding');
        const startNode = findNearestNode(e.data.start[0], e.data.start[1]);
        const endNode = findNearestNode(e.data.end[0], e.data.end[1]);
        
        if (startNode && endNode) {
            const path = findShortestPath(graph, startNode, endNode);
            const coordinates = path.map(nodeId => {
                const node = graph.nodes.get(nodeId);
                return [node.lat, node.lon];
            });
            console.timeEnd('Path Finding');
            self.postMessage({ command: 'pathFound', path, coordinates });
        } else {
            self.postMessage({ command: 'pathNotFound' });
        }
    }
};

function findNearestNode(lat, lon) {
    let nearestNode = null;
    let minDistance = Infinity;

    for (const [nodeId, node] of graph.nodes) {
        const distance = calculateDistance(lat, lon, node.lat, node.lon);
        if (distance < minDistance) {
            minDistance = distance;
            nearestNode = nodeId;
        }
    }

    return nearestNode;
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth's radius in km
    const dLat = deg2rad(lat2 - lat1);
    const dLon = deg2rad(lon2 - lon1);
    const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
        Math.sin(dLon/2) * Ma
        
        
        
        
        
        
        
        
        
        
        
        
        th.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function deg2rad(deg) {
    return deg * (Math.PI/180);
}