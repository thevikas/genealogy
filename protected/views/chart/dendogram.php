<?php //chart ID 0 ?>
<html>
<meta charset="utf-8">
<style>

.node circle {
  fill: #999;
}

.node text {
  font: 10px sans-serif;
}

.node--internal circle {
  fill: #555;
}

.node--internal text {
  text-shadow: 0 1px 0 #fff, 0 -1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff;
}

.link {
  fill: none;
  stroke: #555;
  stroke-opacity: 0.4;
  stroke-width: 1.5px;
}

text.man
{
    fill: blue;
}

text.dead
{
    font-style: italic;
}

text.nodob
{
font-weight: bold;
}

</style>
<p>
<?php
echo $person->namelink . "<br/>";
echo $mother . " " . $father;
?>
</p>

<svg width="<?=$sizes['width']?>" height="<?=$sizes['height']?>"></svg>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://d3js.org/d3.v4.min.js"></script>
<script type="text/javascript">

var svg = d3.select("svg"),
    width = +svg.attr("width"),
    height = +svg.attr("height"),
    g = svg.append("g").attr("transform", "translate(<?=$sizes['translate_x'] ?>,<?=$sizes['translate_y'] ?>)");

var tree = d3.cluster()
    .size([height, width - 160]);

d3.json("?jsononly=1&c=<?=$chart_code?>", function(error, data) {
  if (error) throw error;

  var root = d3.hierarchy(data);

  tree(root);

  var link = g.selectAll(".link")
      .data(root.descendants().slice(1))
    .enter().append("path")
      .attr("class", "link")
      .attr("d", function(d) {
        return "M" + d.y + "," + d.x
            + "C" + (d.parent.y + 100) + "," + d.x
            + " " + (d.parent.y + 100) + "," + d.parent.x
            + " " + d.parent.y + "," + d.parent.x;
      });

  var node = g.selectAll(".node")
      .data(root.descendants())
    .enter().append("g")
      .attr("class", function(d) { return "node" + (d.children ? " node--internal" : " node--leaf"); })
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })

  node.append("circle")
      .attr("r", 2.5);

  node.append("text")
      .attr("dy", 3)
      .attr("x", function(d) { return d.children ? -8 : 8; })
      .attr("class", function(d) {
          return d.data.class;
          })
      .style("text-anchor", function(d) { return d.children ? "end" : "start"; })
      .text(function(d) {
    	  return d.data.name;
    	  });
});

function submit_download_form(output_format)
{
	// Get the d3js SVG element
	var svg = document.getElementsByTagName("svg")[0];
	// Extract the data as SVG text string
	var svg_xml = (new XMLSerializer).serializeToString(svg);

	// Submit the <FORM> to the server.
	// The result will be an attachment file to download.
	var form = document.getElementById("svgform");
	form['output_format'].value = output_format;
	form['data'].value = svg_xml ;
	form.submit();
}


$(document).ready(function() {

	$("#save_as_svg").click(function() { submit_download_form("svg"); });

	$("#save_as_pdf").click(function() { submit_download_form("pdf"); });

	$("#save_as_png").click(function() { submit_download_form("png"); });
});

</script>

<form id="svgform" method="post" action="/chart/download">
 <input type="hidden" id="output_format" name="output_format" value="">
 <input type="hidden" id="data" name="data" value="">
</form>

<!-- ########### The Export Section ####### -->
<div class="row">
	<div class="span12">
		<h2>Export Drawing</h2>

		<br/>
		<button class="btn btn-success" id="save_as_svg" value="">
			Save as SVG</button>
		<button class="btn btn-success" id="save_as_pdf" value="">
			Save as PDF</button>
		<button class="btn btn-success" id="save_as_png" value="">
			Save as High-Res PNG</button>
		<br>
		<br>
		SVG Code:<br>
		<pre class="prettyprint lang-xml" id="svg_code">
		</pre>
	</div>
</div>
</html>
