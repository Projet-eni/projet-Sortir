(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["lieuVille"],{

/***/ "./assets/js/lieuVille.js":
/*!********************************!*\
  !*** ./assets/js/lieuVille.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.onload = init;

function init() {
  document.getElementById('sortie_lieu').addEventListener('change', charge);
  charge();
}

function charge() {
  if (document.getElementById('sortie_lieu') !== null) {
    var lieu = document.getElementById('sortie_lieu');
    afficher(lieu.value);
  } else {
    console.log("erreur");
  }
}

function afficher(value) {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var lieu = JSON.parse(this.responseText);
      document.getElementById("ville").innerText = lieu.ville;
      document.getElementById("rue").innerText = lieu.rue;
      document.getElementById("codePostal").innerText = lieu.codePostal;
      document.getElementById("latitude").innerText = lieu.latitude;
      document.getElementById("longitude").innerText = lieu.longitude;
    }
  };

  xhr.open("GET", "/liste-lieux/" + value, true);
  xhr.send();
}

/***/ })

},[["./assets/js/lieuVille.js","runtime"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbGlldVZpbGxlLmpzIl0sIm5hbWVzIjpbIndpbmRvdyIsIm9ubG9hZCIsImluaXQiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwiYWRkRXZlbnRMaXN0ZW5lciIsImNoYXJnZSIsImxpZXUiLCJhZmZpY2hlciIsInZhbHVlIiwiY29uc29sZSIsImxvZyIsInhociIsIlhNTEh0dHBSZXF1ZXN0Iiwib25yZWFkeXN0YXRlY2hhbmdlIiwicmVhZHlTdGF0ZSIsInN0YXR1cyIsIkpTT04iLCJwYXJzZSIsInJlc3BvbnNlVGV4dCIsImlubmVyVGV4dCIsInZpbGxlIiwicnVlIiwiY29kZVBvc3RhbCIsImxhdGl0dWRlIiwibG9uZ2l0dWRlIiwib3BlbiIsInNlbmQiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBQSxNQUFNLENBQUNDLE1BQVAsR0FBZ0JDLElBQWhCOztBQUVBLFNBQVNBLElBQVQsR0FBZ0I7QUFDWkMsVUFBUSxDQUFDQyxjQUFULENBQXdCLGFBQXhCLEVBQXVDQyxnQkFBdkMsQ0FBd0QsUUFBeEQsRUFBa0VDLE1BQWxFO0FBQ0FBLFFBQU07QUFDVDs7QUFDRCxTQUFTQSxNQUFULEdBQWlCO0FBQ2IsTUFBSUgsUUFBUSxDQUFDQyxjQUFULENBQXdCLGFBQXhCLE1BQXlDLElBQTdDLEVBQWtEO0FBQzlDLFFBQUlHLElBQUksR0FBR0osUUFBUSxDQUFDQyxjQUFULENBQXdCLGFBQXhCLENBQVg7QUFDQUksWUFBUSxDQUFDRCxJQUFJLENBQUNFLEtBQU4sQ0FBUjtBQUNILEdBSEQsTUFJSTtBQUNBQyxXQUFPLENBQUNDLEdBQVIsQ0FBWSxRQUFaO0FBQ0g7QUFHSjs7QUFDRCxTQUFTSCxRQUFULENBQWtCQyxLQUFsQixFQUF3QjtBQUNwQixNQUFJRyxHQUFHLEdBQUcsSUFBSUMsY0FBSixFQUFWOztBQUNBRCxLQUFHLENBQUNFLGtCQUFKLEdBQXlCLFlBQVk7QUFDakMsUUFBSSxLQUFLQyxVQUFMLElBQW1CLENBQW5CLElBQXdCLEtBQUtDLE1BQUwsSUFBZSxHQUEzQyxFQUErQztBQUMzQyxVQUFJVCxJQUFJLEdBQUdVLElBQUksQ0FBQ0MsS0FBTCxDQUFXLEtBQUtDLFlBQWhCLENBQVg7QUFDQWhCLGNBQVEsQ0FBQ0MsY0FBVCxDQUF3QixPQUF4QixFQUFpQ2dCLFNBQWpDLEdBQTZDYixJQUFJLENBQUNjLEtBQWxEO0FBQ0FsQixjQUFRLENBQUNDLGNBQVQsQ0FBd0IsS0FBeEIsRUFBK0JnQixTQUEvQixHQUEyQ2IsSUFBSSxDQUFDZSxHQUFoRDtBQUNBbkIsY0FBUSxDQUFDQyxjQUFULENBQXdCLFlBQXhCLEVBQXNDZ0IsU0FBdEMsR0FBa0RiLElBQUksQ0FBQ2dCLFVBQXZEO0FBQ0FwQixjQUFRLENBQUNDLGNBQVQsQ0FBd0IsVUFBeEIsRUFBb0NnQixTQUFwQyxHQUFnRGIsSUFBSSxDQUFDaUIsUUFBckQ7QUFDQXJCLGNBQVEsQ0FBQ0MsY0FBVCxDQUF3QixXQUF4QixFQUFxQ2dCLFNBQXJDLEdBQWlEYixJQUFJLENBQUNrQixTQUF0RDtBQUNIO0FBQ0osR0FURDs7QUFVQWIsS0FBRyxDQUFDYyxJQUFKLENBQVMsS0FBVCxFQUFnQixrQkFBa0JqQixLQUFsQyxFQUF5QyxJQUF6QztBQUNBRyxLQUFHLENBQUNlLElBQUo7QUFDSCxDIiwiZmlsZSI6ImxpZXVWaWxsZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIndpbmRvdy5vbmxvYWQgPSBpbml0O1xyXG5cclxuZnVuY3Rpb24gaW5pdCgpIHtcclxuICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdzb3J0aWVfbGlldScpLmFkZEV2ZW50TGlzdGVuZXIoJ2NoYW5nZScsIGNoYXJnZSk7XHJcbiAgICBjaGFyZ2UoKTtcclxufVxyXG5mdW5jdGlvbiBjaGFyZ2UoKXtcclxuICAgIGlmIChkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnc29ydGllX2xpZXUnKSE9PW51bGwpe1xyXG4gICAgICAgIGxldCBsaWV1ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3NvcnRpZV9saWV1Jyk7XHJcbiAgICAgICAgYWZmaWNoZXIobGlldS52YWx1ZSk7XHJcbiAgICB9XHJcbiAgICBlbHNle1xyXG4gICAgICAgIGNvbnNvbGUubG9nKFwiZXJyZXVyXCIpO1xyXG4gICAgfVxyXG5cclxuXHJcbn1cclxuZnVuY3Rpb24gYWZmaWNoZXIodmFsdWUpe1xyXG4gICAgbGV0IHhociA9IG5ldyBYTUxIdHRwUmVxdWVzdCgpO1xyXG4gICAgeGhyLm9ucmVhZHlzdGF0ZWNoYW5nZSA9IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBpZiAodGhpcy5yZWFkeVN0YXRlID09IDQgJiYgdGhpcy5zdGF0dXMgPT0gMjAwKXtcclxuICAgICAgICAgICAgdmFyIGxpZXUgPSBKU09OLnBhcnNlKHRoaXMucmVzcG9uc2VUZXh0KTtcclxuICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJ2aWxsZVwiKS5pbm5lclRleHQgPSBsaWV1LnZpbGxlO1xyXG4gICAgICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcInJ1ZVwiKS5pbm5lclRleHQgPSBsaWV1LnJ1ZTtcclxuICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJjb2RlUG9zdGFsXCIpLmlubmVyVGV4dCA9IGxpZXUuY29kZVBvc3RhbDtcclxuICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJsYXRpdHVkZVwiKS5pbm5lclRleHQgPSBsaWV1LmxhdGl0dWRlO1xyXG4gICAgICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcImxvbmdpdHVkZVwiKS5pbm5lclRleHQgPSBsaWV1LmxvbmdpdHVkZTtcclxuICAgICAgICB9XHJcbiAgICB9O1xyXG4gICAgeGhyLm9wZW4oXCJHRVRcIiwgXCIvbGlzdGUtbGlldXgvXCIgKyB2YWx1ZSwgdHJ1ZSk7XHJcbiAgICB4aHIuc2VuZCgpO1xyXG59Il0sInNvdXJjZVJvb3QiOiIifQ==