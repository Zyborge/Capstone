const express = require('express');
const fs = require('fs');
const bodyParser = require('body-parser');
const app = express();
const port = 3000;

app.use(bodyParser.json());

app.post('/saveShapes', (req, res) => {
  // Save the shapes data to shapes.json
  const shapesData = req.body;
  fs.writeFileSync('C:\Users\admin\shapes.nodes.js', JSON.stringify(shapesData));
  res.sendStatus(200);
});

app.get('/loadShapes', (req, res) => {
  // Load shapes data from shapes.json
  fs.readFile('C:\Users\admin\shapes.nodes.js', 'utf-8', (err, data) => {
    if (err) {
      console.error('Error loading shapes data:', err);
      res.status(500).send('Error loading shapes data');
    } else {
      const shapesData = JSON.parse(data);
      res.json(shapesData);
    }
  });
});

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
