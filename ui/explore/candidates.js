let table = new DataTable('#candidates', {
    // options
    order: [
      [ 1, 'asc'], // Users
      [ 5, 'desc'], // Recent Use
      [ 6, 'asc'], // SwS
      [ 9, 'asc'], // AvgT
      [ 7, 'asc'], // MnP
    ] 
  });