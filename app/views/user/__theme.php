<?php
   use yii\bootstrap\ActiveForm;
   use yii\bootstrap\Html;
?>



<div class="row mt-3">
<div class="col-md-8">
<?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>

  <div class="form-group row">
    <label for="panel-theme" class="control-label col-sm-2">Panel Theme</label>
    <div class="col-sm-10">
    <select class="custom-select " name="theme[panel-theme]" id="paneltheme">
      <option value="primary">Primary</option>
      <option value="info">Info</option>
      <option value="dark">Dark</option>
      <!-- <option value="light">Light</option> -->
      <option value="secondary">Secondary</option>
      <option value="danger">Danger</option>
      <option value="success">Success</option>
    </select>
    </div>
  </div>


    <div class="form-group row">
        <label for="side-menu-theme" class="control-label col-sm-2">Side Menu Theme</label>
        <div class="col-sm-10">
        <select class="custom-select " name="theme[sidemenu-theme]" id="gender2">
          <option class="" value="black">Black</option>
          <!-- <option class="" value="white">white</option> -->
          <option class="" value="army">Army</option>
          <!-- <option class="" value="league">league</option> -->
          <!-- <option class="" value="beige">beige</option> -->
          <option class="" value="sky">Sky</option>
          <option class="" value="night">Night</option>
          <option class="" value="purple">Purple</option>
          <option class="" value="serif">Serif</option>
          <option class="" value="simple">Simple</option>
          <option class="" value="solarized">Solarized</option>
          <option class="" value="blood">Blood</option>
          <option class="" value="moon">Moon</option>
          <option value="Blue_Charcoal">Blue_Charcoal</option>
          <option value="Blue_Lagoon">Blue_Lagoon</option>
          <option value="Blue_Opal">Blue_Opal</option>
          <option value="Dark_Navy_Blue">Dark_Navy_Blue</option>
          <option value="Dark_Water">Dark_Water</option>
          <option value="Evening_Blue">Evening_Blue</option>
          <option value="Magnetic_Blue">Magnetic_Blue</option>
          <option value="Medieval_Blue">Medieval_Blue</option>
          <option value="Midnight_Blue">Midnight_Blue</option>
          <option value="Midnight_Navy">Midnight_Navy</option>
          <option value="Night_Blue">Night_Blue</option>
          <option value="Pixie_Powder">Pixie_Powder</option>
          <option value="Reflecting_Pond">Reflecting_Pond</option>
          <option value="Tiber">Tiber</option>
          <option value="Very_Blue">Very_Blue</option>
          <option value="Very_Dark_Blue">Very_Dark_Blue</option>
          <option value="Dark_Green">Dark_Green</option>
          <option value="Dark_Olive">Dark_Olive</option>
          <option value="Dill">Dill</option>
          <option value="Elm_Green">Elm_Green</option>
          <option value="Evergreen">Evergreen</option>
          <option value="Field_Maple">Field_Maple</option>
          <option value="Garden_Green">Garden_Green</option>
          <option value="Green_Brown">Green_Brown</option>
          <option value="Green_Ink">Green_Ink</option>
          <option value="Kabocha_Green">Kabocha_Green</option>
          <option value="Midnight_Green">Midnight_Green</option>
          <option value="Poker_Green">Poker_Green</option>
          <option value="Racing_Green">Racing_Green</option>
          <option value="Smoke_Pine">Smoke_Pine</option>
          <option value="Toad_King">Toad_King</option>
          <option value="Very_Dark_Green">Very_Dark_Green</option>
          <option value="Woodland_Grass">Woodland_Grass</option>
          <option value="Aura_Orange">Aura_Orange</option>
          <option value="Blood_Orange">Blood_Orange</option>
          <option value="Brick_Orange">Brick_Orange</option>
          <option value="Copper_Orange">Copper_Orange</option>
          <option value="Dark_Orange">Dark_Orange</option>
          <option value="Winter_Sunset">Winter_Sunset</option>
          <option value="Capital_Yellow">Capital_Yellow</option>
          <option value="Dark_Yellow">Dark_Yellow</option>
          <option value="Burgundy">Burgundy</option>
          <option value="Burnt_Maroon">Burnt_Maroon</option>
          <option value="Dark_Red">Dark_Red</option>
          <option value="Deep_Maroon">Deep_Maroon</option>
          <option value="Heavy_Red">Heavy_Red</option>
          <option value="Maroon">Maroon</option>
          <option value="Old_Mahagony">Old_Mahagony</option>
          <option value="Pink_Raspberry">Pink_Raspberry</option>
          <option value="Red_Bean">Red_Bean</option>
          <option value="Red_Ink">Red_Ink</option>
          <option value="Rustic_Red">Rustic_Red</option>
          <option value="Rusty_Red">Rusty_Red</option>
          <option value="Celestial_Pink">Celestial_Pink</option>
          <option value="Dark_Hot_Pink">Dark_Hot_Pink</option>
          <option value="Dark_Pink">Dark_Pink</option>
          <option value="Rich_Maroon">Rich_Maroon</option>
          <option value="Alien_Purple">Alien_Purple</option>
          <option value="Brownish_Purple">Brownish_Purple</option>
          <option value="Dark_Purple">Dark_Purple</option>
          <option value="Dark_Strawberry">Dark_Strawberry</option>
          <option value="Deep_Purple">Deep_Purple</option>
          <option value="Medium_Taupe">Medium_Taupe</option>
          <option value="Midnight_Purple">Midnight_Purple</option>
          <option value="Pickled_Beet">Pickled_Beet</option>
          <option value="Purple_Basil">Purple_Basil</option>
          <option value="Purple_Brown">Purple_Brown</option>
          <option value="Purple_Stone">Purple_Stone</option>
          <option value="Antique_Brown">Antique_Brown</option>
          <option value="Blackened_Brown">Blackened_Brown</option>
          <option value="Brown_Stone">Brown_Stone</option>
          <option value="Chestnut">Chestnut</option>
          <option value="Dark_Brown">Dark_Brown</option>
          <option value="Dark_Chocolate">Dark_Chocolate</option>
          <option value="Deep_Brown">Deep_Brown</option>
          <option value="Earth_Brown">Earth_Brown</option>
          <option value="Flat_Brown">Flat_Brown</option>
          <option value="Grey_Brown">Grey_Brown</option>
          <option value="Hardwood">Hardwood</option>
          <option value="Marsh">Marsh</option>
          <option value="Polished_Brown">Polished_Brown</option>
          <option value="Toffee">Toffee</option>
          <option value="Tree_House">Tree_House</option>
          <option value="Tuk_Tuk">Tuk_Tuk</option>
          <option value="Alien">Alien</option>
          <option value="Brick_Grey">Brick_Grey</option>
          <option value="Cape_Cod">Cape_Cod</option>
          <option value="Carbon">Carbon</option>
          <option value="Dark_Grey">Dark_Grey</option>
          <option value="Dusty_Olive">Dusty_Olive</option>
          <option value="Flint">Flint</option>
          <option value="Heavy_Charcoal">Heavy_Charcoal</option>
          <option value="Holly">Holly</option>
          <option value="Lunar_Green">Lunar_Green</option>
          <option value="Night_Sky">Night_Sky</option>
          <option value="Polished_Steel">Polished_Steel</option>
          <option value="Soft_Steel">Soft_Steel</option>
          <option value="Space_Grey">Space_Grey</option>
          <option value="Tap_Shoe">Tap_Shoe</option>
          <option value="Tarmac">Tarmac</option>
          <option value="Thyme">Thyme</option>
          <option value="Very_Dark_Brown">Very_Dark_Brown</option>
          <option value="Walnut_Hull">Walnut_Hull</option>
          <option value="Black_Olive">Black_Olive</option>
          <option value="Black_Pearl">Black_Pearl</option>
          <option value="Coffee_Bean">Coffee_Bean</option>
          <option value="Cynical_Black">Cynical_Black</option>
          <option value="Kurobeni">Kurobeni</option>
          <option value="Liquorice">Liquorice</option>
          <option value="Pot_Black">Pot_Black</option>
          <option value="Reversed_Grey">Reversed_Grey</option>
          <option value="Sepia_Black">Sepia_Black</option>
          <option value="Void">Void</option>
          <option value="Wood_Bark">Wood_Bark</option>
          <option value="Black_Chocolate">Black_Chocolate</option>
          <option value="Black_Coffee">Black_Coffee</option>

        </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="lname" class="control-label col-sm-2">Top Bar Theme</label>
        <div class="col-sm-10">
          <select class="custom-select " name="theme[topbar-theme]" id="gender2">

            <option value="Alice">Alice</option>
            <option value="Baby">Baby</option>
            <option value="Blue">Blue</option>
            <option value="Bubbles">Bubbles</option>
            <option value="Fresh">Fresh</option>

            <option value="Frozen">Frozen</option>
            <option value="Iceberg">Iceberg</option>
            <option value="Light">Light</option>

            <option value="Milky">Milky</option>
            <option value="Morning">Morning</option>
            <option value="Niagara">Niagara</option>
            <option value="Pale">Pale</option>
            <option value="Princess">Princess</option>
            <option value="Sail">Sail</option>
            <option value="Sea">Sea</option>
            <option value="Skylight">Skylight</option>
            <option value="Soap">Soap</option>
            <option value="Spring">Spring</option>
            <option value="Starburst">Starburst</option>
            <option value="Starlight">Starlight</option>
            <option value="Subtle">Subtle</option>
            <option value="Summer">Summer</option>
            <option value="Tinted">Tinted</option>
            <option value="Transparent">Transparent</option>
            <option value="Tropical">Tropical</option>
            <option value="Uranus">Uranus</option>
            <option value="Very">Very</option>
            <option value="Warm">Warm</option>
            <option value="Waterspout">Waterspout</option>
            <option value="Wave">Wave</option>
            <option value="Whisper">Whisper</option>
            <option value="Winter">Winter</option>
            <option value="Winter">Winter</option>
            <option value="Winterday">Winter Day</option>
            <option value="Yucca">Yucca</option>
            <option value="Zephyr">Zephyr</option>
            <option value="Bone">Bone</option>
            <option value="Brilliant">Brilliant</option>
            <option value="Buttery">Buttery</option>
            <option value="Chickpea">Chickpea</option>
            <option value="Cocoon">Cocoon</option>
            <option value="Golden">Golden</option>
            <option value="Honey">Honey</option>
            <option value="Lace">Lace</option>
            <option value="Latte">Latte</option>
            <option value="Light">Light</option>
            <option value="Lightshade">Light Shade</option>
            <option value="Lima">Lima</option>
            <option value="Macadamia">Macadamia</option>
            <option value="Marble">Marble</option>
            <option value="Marshmallow">Marshmallow</option>
            <option value="Milk">Milk</option>
            <option value="Moonlight">Moonlight</option>
          </select>
        </div>
    </div>

    <div class="form-group text-right">

        <?= Html::submitButton(Yii::t('app', "Update"), ['class' => 'btn btn-success']) ?>

    </div>
  <?php ActiveForm::end(); ?>
</div>
</div>

<script>



$('select[name="theme[topbar-theme]"]')
    .val('<?= Yii::$app->config->get('topbar-theme','simple'); ?>')
    .trigger('change');
$('select[name="theme[sidemenu-theme]"]')
    .val('<?= Yii::$app->config->get('sidemenu-theme','simple'); ?>')
    .trigger('change');
$('select[name="theme[panel-theme]"]')
    .val('<?= Yii::$app->config->get('panel-theme','primary'); ?>')
    .trigger('change');


</script>
