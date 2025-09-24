<style>
$('table').on('scroll', function() {
  $("table > *").width($("table").width() + $("table").scrollLeft());
});

html {
  font-family: verdana;
  font-size: 10pt;
  line-height: 25px;
}

table {
  border-collapse: collapse;
  width: 300px;
  overflow-x: scroll;
  display: block;
}

thead {
  background-color: #EFEFEF;
}

thead,
tbody {
  display: block;
}

tbody {
  overflow-y: scroll;
  overflow-x: hidden;
  height: 140px;
}

td,
th {
  min-width: 100px;
  height: 25px;
  border: dashed 1px lightblue;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<table>
  <thead>
    <tr>
      <th>Column 1</th>
      <th>Column 2</th>
      <th>Column 3</th>
      <th>Column 4</th>
      <th>Column 5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>AAAAAAAAAAAAAAAAAAAAAAAAAA</td>
      <td>Row 1</td>
      <td>Row 1</td>
      <td>Row 1</td>
      <td>Row 1</td>
    </tr>
    <tr>
      <td>Row 2</td>
      <td>Row 2</td>
      <td>Row 2</td>
      <td>Row 2</td>
      <td>Row 2</td>
    </tr>
    <tr>
      <td>Row 3</td>
      <td>Row 3</td>
      <td>Row 3</td>
      <td>Row 3</td>
      <td>Row 3</td>
    </tr>
    <tr>
      <td>Row 4</td>
      <td>Row 4</td>
      <td>Row 4</td>
      <td>Row 4</td>
      <td>Row 4</td>
    </tr>
    <tr>
      <td>Row 5</td>
      <td>Row 5</td>
      <td>Row 5</td>
      <td>Row 5</td>
      <td>Row 5</td>
    </tr>
    <tr>
      <td>Row 6</td>
      <td>Row 6</td>
      <td>Row 6</td>
      <td>Row 6</td>
      <td>Row 6</td>
    </tr>
    <tr>
      <td>Row 7</td>
      <td>Row 7</td>
      <td>Row 7</td>
      <td>Row 7</td>
      <td>Row 7</td>
    </tr>
    <tr>
      <td>Row 8</td>
      <td>Row 8</td>
      <td>Row 8</td>
      <td>Row 8</td>
      <td>Row 8</td>
    </tr>
    <tr>
      <td>Row 9</td>
      <td>Row 9</td>
      <td>Row 9</td>
      <td>Row 9</td>
      <td>Row 9</td>
    </tr>
    <tr>
      <td>Row 10</td>
      <td>Row 10</td>
      <td>Row 10</td>
      <td>Row 10</td>
      <td>Row 10</td>
    </tr>
  </tbody>
</table>