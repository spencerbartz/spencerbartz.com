var graph = new function() {
	this.canvas = document.getElementById("graph");
	this.ctx = this.canvas.getContext("2d");
	this.xOffset = 40;
	this.yOffset = 30;
	this.scaleFactor = 20;
	this.ctx.font = "" + this.scaleFactor / 2 + "px Arial";
	
	this.drawAxes = function() {
		//draw y-axis
		this.ctx.beginPath();
		this.ctx.moveTo(this.xOffset, 0);
		this.ctx.lineTo(this.xOffset, this.canvas.height - this.yOffset);
		this.ctx.strokeStyle = '#000000';
		this.ctx.stroke();
		
		//draw x-axis
		this.ctx.lineTo(this.canvas.width - this.xOffset, this.canvas.height - this.yOffset);
		this.ctx.stroke();
		this.ctx.closePath();
	};
	
	this.drawTickMarks = function() {
		var tickLength = 10;
		this.ctx.textAlign = "right";
		
		//draw y-axis tick marks and labels from top to bottom
		for(var y = this.scaleFactor - this.yOffset; y < this.canvas.height - this.yOffset; y += this.scaleFactor) {
			this.ctx.strokeStyle = '#000000';
			this.ctx.fillText("" +   (this.canvas.height - this.yOffset - y)/2 + "", this.xOffset - tickLength, y + 3);
			this.ctx.beginPath();
			this.ctx.moveTo(this.xOffset - tickLength/2, y);
			this.ctx.lineTo(this.xOffset + tickLength/2, y);
			this.ctx.stroke();
			this.ctx.closePath();
			
			this.ctx.beginPath();
			this.ctx.moveTo(this.xOffset + tickLength/2, y);
			this.ctx.lineTo(this.canvas.width - this.xOffset, y);
			this.ctx.strokeStyle = '#AAAAFF';
			this.ctx.stroke();
			this.ctx.closePath();
		}
		
		this.ctx.textAlign = "left";
		//draw x-axis tick marks and labels from left to right
		for(var x = this.scaleFactor + this.xOffset; x <= this.canvas.width - this.xOffset; x += this.scaleFactor) {
			this.ctx.strokeStyle = '#000000';
			this.ctx.fillText("" +  (x  - (x % this.scaleFactor))/2 - 20 + "", x - tickLength/2 - 2, this.canvas.height - this.yOffset + tickLength * 2);
			
			this.ctx.beginPath();
			this.ctx.moveTo(x, this.canvas.height - this.yOffset - tickLength/2);
			this.ctx.lineTo(x, this.canvas.height - this.yOffset + tickLength/2);
			this.ctx.strokeStyle = '#000000';
			this.ctx.stroke();
			this.ctx.closePath();
			
			this.ctx.beginPath();
			this.ctx.moveTo(x, this.canvas.height - this.yOffset - tickLength/2);
			this.ctx.lineTo(x, 0);
			this.ctx.strokeStyle = '#AAAAFF';
			this.ctx.stroke();
			this.ctx.closePath();
		}
	};
};

graph.drawAxes();
graph.drawTickMarks();
