<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>
</head>
<body>
  <h1>Form</h1>
  <form action="processForm.php" method="post">

    <div>
      <label for="select">Select</label>
      <select name="select[]" id="select">
        <option value="One">One</option>
        <option value="Two">Two</option>
      </select>
    </div>

    <div>
      <label for="select">Select</label>`
      <select name="select[]" id="select">
        <option value="One">One</option>
        <option value="Two">Two</option>
      </select>
    </div>

    <button type="submit">Submit</button>
  </form>
</body>
</html>