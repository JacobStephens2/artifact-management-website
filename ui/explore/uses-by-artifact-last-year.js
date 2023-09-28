let table = new DataTable('#usesByArtifact', {
    // options
    order: [
      [ 0, 'desc'], // uses most first
      [ 1, 'asc'], // artifact
    ] 
  });