<footer class="text-center mt-5" style =  "text-align: center; padding: 3px;">
        Copyright &copy; Sabah Forestry Department 2022. All Rights Reserved.
        <div>
          Any Enquiries?Please<a href="https://jpkn.sabah.gov.my/">Contact us</a>
        </div>
      </footer>

<!-- JAVASCRIPTS -->
<script>
  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  }

    // Add active class to the current button (highlight it)
  var header = document.getElementById("myDIV");
  var btns = header.getElementsByClassName("btn");
  for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    if (current.length > 0) { 
      current[0].className = current[0].className.replace(" active", "");
    }
    this.className += " active";
    });
  }

  function printDiv(divName){
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
  }

</script>

</body>
</html>

<?php ob_end_flush(); ?>