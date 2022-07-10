<!-- <script type="text/javascript" src="jquery-2.0.0.min.js"></script> -->
<link href="custom/css/smart_wizard_vertical.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="custom/js/jquery.smartWizard.js"></script>
<style>
    .content{
        width:100% !important;
        /* height:100% !important; */
    height:100% !important;

    }
    .swMain {
    /* position: relative;
    display: block;
    margin: 0;
    padding: 0;
    border: 0px solid #CCC;
    overflow: visible; */
    float: none !important;
    width:100%;
    height:100% !important;

    }
    .swMain ul.anchor li a.selected {
	color: #F8F8F8;
	background: #E74C3C !important;
	border: 1px solid #8E5B1F;
	cursor: text;
	-moz-box-shadow: 1px 5px 10px #888;
	-webkit-box-shadow: 1px 5px 10px #888;
	box-shadow: 1px 5px 10px #888;
    }

    .stepContainer{
        height:100% !important;

    }
    .swMain ul.anchor li a.done {
    position: relative;
    color: #FFF;
    background: #28A745 !important;
    border: 1px solid #8CC63F;
    z-index: 99;
}
</style>
<div class="row">
    <div class="col-md-12">
    <div id="wizard" class="swMain">
  <ul>
    <li><a href="#step-1">
          <label class="stepNumber">1</label>
          <span class="stepDesc">
            
             T.P DETAILS
          </span>
      </a></li>
    <li><a href="#step-2">
          <label class="stepNumber">2</label>
          <span class="stepDesc">
             PAYMENTS
          </span>
      </a></li>
    <li><a href="#step-3">
          <label class="stepNumber">3</label>
          <span class="stepDesc">
             BANK 
          </span>                   
       </a>
    </li>
    <li><a href="#step-4">
          <label class="stepNumber">4</label>
          <span class="stepDesc">
          T E C
          </span>                   
      </a>
    </li>
    <li><a href="#step-5">
          <label class="stepNumber">4</label>
          <span class="stepDesc">
          ADDRESS 
          </span>                   
      </a>
    </li>
    <li><a href="#step-6">
          <label class="stepNumber">6</label>
          <span class="stepDesc">
             SPOC
          </span>                   
      </a>
    </li>
    <li>
        <a href="#step-7">
          <label class="stepNumber">7</label>
          <span class="stepDesc">
             CEO/MD
          </span>                   
      </a>
    </li>
    <li>
        <a href="#step-8">
          <label class="stepNumber">8</label>
          <span class="stepDesc">
           SPOCF
          </span>                   
      </a>
    </li>
    
  </ul>
  <div id="step-1">   
      <h2 class="StepTitle">TRAINING PARTNER DETAILS</h2>
       <!-- step content -->
  </div>
  <div id="step-2">
      <h2 class="StepTitle">DATA REQUIRED FOR INVOICES AND PAYMENTS</h2> 
       <!-- step content -->
  </div>                      
  <div id="step-3">
      <h2 class="StepTitle">BANK DETAILS</h2>   
       <!-- step content -->
  </div>
  <div id="step-4">
      <h2 class="StepTitle">TAX EXEMPTION CERTIFICATE, IF ANY</h2>   
       <!-- step content -->                         
  </div><div id="step-5">
      <h2 class="StepTitle">ADDRESS DETAILS</h2>   
       <!-- step content -->                         
  </div><div id="step-6">
      <h2 class="StepTitle">SINGLE POINT OF CONTACT-OPERATION (SPOC-OPERATION)</h2>   
       <!-- step content -->                         
  </div><div id="step-7">
      <h2 class="StepTitle">CEO/MD</h2>   
       <!-- step content -->                         
  </div>
  <div id="step-8">
      <h2 class="StepTitle">SINGLE POINT OF CONTACT-FINANCE (SPOC-FINANCE)</h2>   
       <!-- step content -->                         
  </div> 
</div>
</div>

    </div>

</div>

<script>
jQuery(document).ready(function(){

jQuery('#wizard').smartWizard({transitionEffect:'slideleft'});

}); 
 
 </script>