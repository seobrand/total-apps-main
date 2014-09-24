<div class="powerwidget" id="widget3">
  <header>
    <h2>Job Detail</h2>
  </header>
  <div id="pagingcontent" >
    <table class="clean-table" id="clean-table" >
      <tr>
        <td width="20"></td>
        <td>Title</td>
        <td width="30" align="center">:</td>
        <td><?php echo $News['News']['title']; ?></td>
      </tr>
      <tr>
        <td width="20"></td>
        <td>Description</td>
        <td width="30" align="center">:</td>
        <td><?php echo $News['News']['description']; ?></td>
      </tr>
      <tr>
        <td width="20"></td>
        <td>Publish Date</td>
        <td width="20">:</td>
        <td><?php echo date('d-M-Y',$News['News']['start_date']); ?></td>
      </tr>
      <tr>
        <td width="20"></td>
        <td>End Date</td>
        <td width="30" align="center">:</td>
        <td><?php echo date('d-M-Y',$News['News']['end_date']); ?></td>
      </tr>
    </table>
  </div>
</div>
<!-- End .powerwidget -->
