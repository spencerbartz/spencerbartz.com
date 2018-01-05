function deletePrompt(forumname, topicname, postid)
{
	if (confirm("Do you really want to delete this post?")) 
	{ 
		window.location.assign("deletepost.php?forum=" + forumname + "&topic=" + topicname + "&postid=" + postid);
	}
}

function submitenter(myfield,e)
{
	var keycode;
	if(window.event) 
		keycode = window.event.keyCode;
        else if (e) 
        	keycode = e.which;
        else return true;

	if(keycode == 13)
	{
		myfield.form.submit();
		return false;
        }
        else
            return true;
    }

/**********************AJAX FUNCTIONS**********************/

//expecting two strings from a form - author and posttext. we will use these to update the database

function updatePostList(textAreaName, forum, topic, username)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	
	xmlhttp.onreadystatechange = function()
	 {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById('post_list').innerHTML = xmlhttp.responseText;
			updateNumPosts(forum, topic);
		}
	 }
	 
	xmlhttp.open("POST", "process_newpost.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send('posttext=' + document.getElementById(textAreaName).value + '&forumname=' + forum + '&topicname=' + topic +  '&username=' + username);
	
	
}

function updateNumPosts(forum, topic)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  
	xmlhttp.onreadystatechange = function()
	 {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById('postcount').innerHTML = xmlhttp.responseText;
		}
	 }

	 xmlhttp.open("POST", "getnumposts.php", true);
	 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	 xmlhttp.send("forumname=" + forum + "&topicname=" + topic);
	
}

function clearTextArea(textAreaId)
{
	document.getElementById(textAreaId).value = "";
}

function toggleVisible(elementId)
{
	
	var elem = document.getElementById(elementId);	

	
	if(elem.style.visibility == 'hidden')
	{
		elem.style.visibility = 'visible';
	}
	else
	{
		elem.style.visibility = 'hidden';
	}
}

function toggleDisplay(elementId)
{
	var elem = document.getElementById(elementId);	

	if(elem.style.display == 'none')
	{
		elem.style.display = 'inline-block';
	}
	else
	{
		elem.style.display = 'none';
	}
}

function doAlert()
{
	alert("horrie!");
}

function getBrowserInfo()
{
//Copied from http://www.quirksmode.org/js/detect.html
var BrowserDetect = 
{
	init: function () 
	{
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) 
	{
		for (var i=0;i<data.length;i++)	
		{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) 
			{
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) 
	{
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();
return BrowserDetect;
}