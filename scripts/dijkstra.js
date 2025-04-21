class PriorityQueue {
  constructor() {
    this.collection = [];
  }
  enqueue(element) {
    if (this.isEmpty()) {
      this.collection.push(element);
    } else {
      let added = false;
      for (let i = 1; i <= this.collection.length; i++) {
        if (element[1] < this.collection[i - 1][1]) {
          this.collection.splice(i - 1, 0, element);
          added = true;
          break;
        }
      }
      if (!added) {
        this.collection.push(element);
      }
    }
  }
  dequeue() {
    return this.collection.shift();
  }
  isEmpty() {
    return this.collection.length === 0;
  }
}

function dijkstra(graph, startNode) {
  let distances = {};
  let prev = {};
  let pq = new PriorityQueue();

  distances[startNode] = 0;
  pq.enqueue([startNode, 0]);

  for (let vertex in graph) {
    if (vertex !== startNode) {
      distances[vertex] = Infinity;
    }
    prev[vertex] = null;
  }

  while (!pq.isEmpty()) {
    let minNode = pq.dequeue();
    let currentNode = minNode[0];
    let currentDist = minNode[1];

    graph[currentNode].forEach((neighbor) => {
      let alt = currentDist + neighbor[1];
      if (alt < distances[neighbor[0]]) {
        distances[neighbor[0]] = alt;
        prev[neighbor[0]] = currentNode;
        pq.enqueue([neighbor[0], distances[neighbor[0]]]);
      }
    });
  }
  return { distances, prev };
}

// Example usage:
const graph = {
  1: [
    [2, 1],
    [3, 4],
  ],
  2: [
    [1, 1],
    [3, 2],
    [4, 5],
  ],
  3: [
    [1, 4],
    [2, 2],
    [4, 1],
  ],
  4: [
    [2, 5],
    [3, 1],
  ],
};

const { distances, prev } = dijkstra(graph, "1");
console.log(distances);
console.log(prev);
