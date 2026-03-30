<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../public/assets/css/upgrade.css">
        <title>Upgrade</title>
    </head>
    <body>
        <div class="card">
            <div class="back">
                <button><</button>
                <h3>Upgrade to Artisan account</h3>
                
            </div>
            <div class="info-upgrade">
            <div class="form-group">
            <label>Shop Name</label>
            <input type="text" placeholder="example: hirfa shop">
            </div>
            <div class="form-group">
            <label>Choose your category</label> 
            <select>
                <option>else</option>
                <option>Wood</option>
            </select>
        </div>
            <div class="form-group">
  <label>Service definition</label>
  <textarea></textarea>
</div>
<div class="form-group">
            <label>Cover to your shop!</label> 
            <label for="avatarInput" class="btn-browse">Browse</label>
            <input type="file" id="avatarInput" hidden />   
            <span id="fileName"><i style="color: rgb(77, 77, 77) ;">No file selected</i></span>  
        </div>
           
            </div>
         <div class="update">
            <button>Save</button>
            </div> 

        </div>
<script>
document.getElementById('avatarInput').addEventListener('change', function() {
  const file = this.files[0];
  fileName.textContent = file.name;
});
</script> 
    </body>
</html>