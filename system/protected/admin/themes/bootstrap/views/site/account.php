<style>
.panel {
    background-color: #FFFFFF;
    /*border: 1px solid rgba(0, 0, 0, 0);*/
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
}
.panel-primary {
    border-color: #428BCA;
}   
.panel-primary > .panel-heading {
    background-color: #428BCA;
    border-color: #428BCA;
    color: #FFFFFF;
}   
.panel-heading {
    border-bottom: 1px solid rgba(0, 0, 0, 0);
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    padding: 10px 15px;
}   
.panel-title {
    font-size: 16px;
    margin-bottom: 0;
    margin-top: 0;
}   
.panel-body:before, .panel-body:after {
    content: " ";
    display: table;
}   
.panel-body:before, .panel-body:after {
    content: " ";
    display: table;
}   
.panel-body:after {
    clear: both;
}   
.panel-body {
    padding: 15px;
} 
</style>

<fieldset>
    <legend><i class="icon-fixed-width icon-user"></i> My AsianBrain Account</legend>
</fieldset>

<div class="panel panel-primary">
  <div class="panel-body">
    <div class="row-fluid">
      <div class="span3">
        <img class="img-circle" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100" alt="User Pic">
      </div>
      <div class="span6">
        <strong><?php echo Yii::app()->user->getState('nickname') ?></strong><br>
        <table class="table table-condensed table-responsive table-user-information">
          <tbody>
          <tr>
            <td>Username:</td>
            <td><?php echo Yii::app()->user->getState('username') ?></td>
          </tr>
          <tr>
            <td>Status:</td>
            <td><?php echo Yii::app()->user->getState('status') ?></td>
          </tr>
          <tr>
            <td>Email:</td>
            <td><?php echo Yii::app()->user->getState('email') ?></td>
          </tr>
          <tr>
            <td>Last Login:</td>
            <td><?php echo Yii::app()->user->getState('lastLogin') ?></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>