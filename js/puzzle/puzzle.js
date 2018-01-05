var state = "up"
var mouseX = 0
var mouseY = 0
var curImage = ""
var imgClickX = 0
var imgClickY = 0
var numImages = 11

function generatePieces()
{
	for(var i = 0; i < numImages; i++)
	{
		var xCoord = Math.round(Math.random() * 500)
		var yCoord = Math.round(Math.random() * 500)
		document.write('<img id="piece' + i + '" src="images/' + i + '.gif" onclick="doImgClick(event, this.id)" style="position:absolute; top: ' + yCoord + 'px; left: ' + xCoord + 'px; z-index:0;">')
	}
	
}

function doImgClick(mouseEvent, id)
{
	//"Select" the image
	toggleBorder(id, "medium solid red")
	toggleCurImage(id)
	setZIndex(id)

	//compute where on the image the click event occurred
	element = document.getElementById(id)

	imgClickX = mouseEvent.clientX - parseInt(element.style.left)
	imgClickY = mouseEvent.clientY - parseInt(element.style.top)
}

function doMouseMove(mouseEvent)
{
	if(curImage == "")
		return

	mouseX = mouseEvent.clientX
	mouseY = mouseEvent.clientY

	element = document.getElementById(curImage)

	if(!element)
	{
		alert("Error: Element not found.")
		return;
	}

	//reset the x and y coordinates for the image
	if(element.style.left)
		element.style.left = (mouseX - imgClickX) +  "px"
	else
		alert("element had no left coordinate defined")

	if(element.style.top)
		element.style.top = (mouseY - imgClickY) + "px"
	else
		alert("element had no top coordinate defined")
}

function setZIndex(id)
{
	element = document.getElementById(id)

	element.style.zIndex = "1"

	for(var i = 0; i < document.images.length; i++)
		if(document.images[i].id != id)
			document.images[i].style.zIndex = "0"
}

function toggleCurImage(id)
{
	curImage = curImage == "" ? id : ""
}



//*********************** UTILITY FUNCTIONS *************************

function toggleDiv(elementId)
{
	element = document.getElementById(elementId)

	if(!element)
	{
		alert("Error: Element not found.")
		return;
	}

	element.style.display = element.style.display == "block" ? "none" : "block"
}

function toggleBorder(elementId, borderStyle)
{
	if(!borderStyle)
		borderStyle = "groove"

	element = document.getElementById(elementId)
	element.style.border = element.style.border == "" ? borderStyle : ""
}