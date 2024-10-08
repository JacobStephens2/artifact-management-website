document.querySelector('#send_use_email').addEventListener('click', function(event) {
    async function getData(userID) {
      var apiOrigin = document.querySelector('#apiOrigin').content;
      const url = `https://${apiOrigin}/send_use_email.php?userID=${userID}`;
      try {
        const response = await fetch(url);
        if (!response.ok) {
          throw new Error(`Response status: ${response.status}`);
        }
    
        const json = await response.json();
        console.log(json);
        if (json.count_to_notify_about != null) {
          alert(`Email sent with notification about ${json.count_to_notify_about} artifacts.`);
        }
      } catch (error) {
        console.error(error.message);
      }
    }
    var userID = event.target.dataset.userid;
    getData(userID);
})