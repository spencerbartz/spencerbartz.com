var projectile = new function() {
    this.canvas = document.getElementById("graph");
	this.ctx = this.canvas.getContext("2d");
    
    this.drawCurve = function(v0, theta) {
        var coords = this.calculateCoordinates(v0, theta);
        var self = this;    // this 'this' is not available in anonymous functions
        var startCoord = {x: 0, y: 0 };
        var count = 0;
        
        this.ctx.save();
        this.ctx.translate(40, self.canvas.height - 30);
        _.each(coords, function(coord) {
            self.ctx.beginPath();
            self.ctx.moveTo(startCoord.x, -startCoord.y);
            self.ctx.lineTo(coord.x, -coord.y);
            startCoord = { x: coord.x, y:  coord.y };
            self.ctx.strokeStyle = '#000000';
            self.ctx.stroke();
            self.ctx.closePath();
            count++;
        });
        this.ctx.restore();
    };
    
    this.calculateCoordinates = function(v0, theta) {
        var coords = [];
        var max = 720;
        
        for(var x = 0; x <= max; x++) {
            var y = this.calculateHeight(v0, theta, x);
            coords.push({"x": x, "y": y});
            if(y < 0)
                break;
        }
        
        return coords;
    };
    
    this.calculateHeight = function(v0, theta, x) {
        var y = x * Math.tan(theta) + (9.8 * Math.pow(x, 2)) / (2 * Math.pow(v0, 2) * Math.pow(Math.cos(theta), 2));
        return Math.round(-y);
    };
};

$(function() {
    // Wire up non-intrusive event handling
    $('#input-form').submit(function(e) {
        e.preventDefault();
        var values = {};
        $.each($(this).serializeArray(), function(i, field) {
            values[field.name] = parseInt(field.value);
        });
        values.theta = -values.theta * Math.PI/180; // js trig functions take radians, and we're drawing in the 4th quadrant
        projectile.drawCurve(values.v0, values.theta);
    });
});