/**
 * 
 */
var b = document.getElementById("box");
writehere.value = b.clientWidth + "px X " + b.clientHeight + "px";
var aa = document.getElementsByTagName("a");
i=0;
//alert(aa.length);
for(i=0; i<aa.length;i++)
{
	athis = aa[i];
	if(athis.hasAttribute("cid"))
	{
		athis.setAttribute("onclick","handleperson(event,this,'" + athis.href + "')");
		athis.setAttribute("onmouseover","handleperson(event,this,'" + athis.href + "')");
		//athis.href="javascript:;";
		//athis.href = "haha";
	}
}

function hideEdit()
{
	document.edit_now.sibling.style.display = "inline";
	t2 = document.edit_now.parentNode;
	//alert(t2.removeChild);
	t2.removeChild(document.edit_now);
	document.edit_now  = null;
}

function handleperson(e,t)
{
	//alert(e.ctrlKey + "," + e.altKey + "," + e.shiftKey);
	if(e.ctrlKey)
	{
		if(document.edit_now)
		{
			hideEdit();
		}
		//alert(t.getAttribute("cid"));
		t.href="#";
		ip = document.createElement("input");
		ip.value = t.innerHTML;
		////visibility="hidden";
		ip.style.width = t.offsetWidth + "px";
		ip.style.borderWidth = "0px";
		ip.cid = t.getAttribute("cid");
		ip.name = "change-name";
		ip.sibling = t;
		ip.setAttribute("onkeyup","dokeyup(event,this)");
		t.style.display="none";
		t.parentNode.insertBefore(ip,t);
		document.edit_now = ip;
		//.appendChild(ip);
		return true;
	}
}

function addspouse(t,gender,cid)
{
	if(document.edit_now)
	{
		hideEdit();
	}
	//alert(t.getAttribute("cid"));
	t.href="#";

	ip1 = document.createElement("input");
	if(gender)
		ip1.value = 'Husband';
	else
		ip1.value = 'Wife';

	////visibility="hidden";
	ip1.className = 'tree-add-spouse';
	ip1.cid = cid;
	ip1.gender = gender;
	ip1.sibling = t;
	ip1.setAttribute("onkeyup","dokeyup(event,this)");

	if(gender)
		ip1.name = "add-husband";
	else
		ip1.name = "add-wife";

	t.style.display="none";
	t.parentNode.insertBefore(ip1,t);

	document.edit_now = new array(ip,ip2);
	//.appendChild(ip);
	return true;
}

function addchild(t,fcid,mcid)
{
	if(document.edit_now)
	{
		hideEdit();
	}
	//alert(t.getAttribute("cid"));
	t.href="#";

	ip1 = document.createElement("input");
	ip1.value = 'Son';
	////visibility="hidden";
	ip1.className = 'tree-add-child';
	ip1.fcid = fcid;
	ip1.mcid = mcid;
	ip1.sibling = t;
	ip1.setAttribute("onkeyup","dokeyup(event,this)");
	ip1.name = "male-child";
	t.style.display="none";
	t.parentNode.insertBefore(ip1,t);

	ip2 = document.createElement("input");
	ip2.value = 'Daughter';
	////visibility="hidden";
	ip2.className = 'tree-add-child';
	ip2.fcid = fcid;
	ip2.mcid = mcid;
	ip2.sibling = t;
	ip2.setAttribute("onkeyup","dokeyup(event,this)");
	ip2.name = "female-child";
	t.style.display="none";
	t.parentNode.insertBefore(ip2,t);

	document.edit_now = new array(ip,ip2);
	//.appendChild(ip);
	return true;
}

function dokeyup(e,t)
{
	if(e.keyCode == 13)
	{
		if(t.name == 'change-name')
			changeName(t.cid,t.value);
		else if(t.name == 'female-child')
			sendnewChild(0,t.value,t.fcid,t.mcid);
		else if(t.name == 'male-child')
			sendnewChild(1,t.value,t.fcid,t.mcid);
		else if(t.name == 'add-husband')
			sendnewSpouse(1,t.value,t.cid);
		else if(t.name == 'add-wife')
			sendnewSpouse(0,t.value,t.cid);
		hideEdit();
	}

	else if(e.keyCode == 27)
	{
		hideEdit();
	}
}

function sendnewChild(gender,childname,fcid,mcid)
{
	var url = "ajax.php?job=2&name=" + childname + "&fcid=" + fcid + "&mcid=" + mcid + "&gender=" + gender + "&r=" + Math.random();
	sendJob(url);
}

function sendnewSpouse(gender,name,cid)
{
	var url = "ajax.php?job=3&name=" + name + "&cid=" + cid + "&gender=" + gender + "&r=" + Math.random();
	sendJob(url);
}

function changeName(cid,new_name)
{
	//clearTimeout(cdown_timer);
	//debugprinting=yes shows lots of debug data
	//for any purpose, this ajax won't need it.
	var url = "ajax.php?job=1&cid=" + cid + "&name=" + new_name + "&r=" + Math.random();
	sendJob(url);
}

function sendJob(url)
{
    if (window.XMLHttpRequest) {
        xmlobj = new XMLHttpRequest();
        xmlobj.onreadystatechange = processReq;
        xmlobj.open("GET", url, true);
        xmlobj.send(null);
    // branch for IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
        xmlobj = new ActiveXObject("Microsoft.XMLHTTP");
        if (xmlobj) {
            xmlobj.onreadystatechange = processReq;
            xmlobj.open("GET", url, true);
            xmlobj.send();
        }
    }
}

function processReq() {
    if (xmlobj.readyState == 4) {
		// only if "OK"

		if (xmlobj.status == 200) {
			queue_clear=true;
			//alert("done");
		}
	}
}