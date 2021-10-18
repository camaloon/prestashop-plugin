<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 status-container">
      <h2>{l s='System status' mod='camaloon'}</h2>
      <div class="description">
        {l s='Review the status of your connection. Errors in the connection of your store setup may cause the Camaloon integration to not work as intended.' mod='camaloon'}
      </div>
      <div class="table-responsive-row clearfix">
        <table class="table table-hover">
          <thead>
            <tr>
              <td><h3>{l s='Name' mod='camaloon'}</h3></td>
              <td><h3>{l s='Description' mod='camaloon'}</h3></td>
              <td class="text-center"><h3>{l s='Status' mod='camaloon'}</h3></td>
            </tr>
        </thead>
        {foreach key=key item=item from=$items}
            <tr>
              <td>{$item['name']}</td>
              <td>{$item['description']}</td>
              <td class="text-center {($item['value'] == 1) ? 'success' : 'danger'}">{($item['value'] == 1) ? 'OK' : 'FAIL'}</td>
            </tr>
        {/foreach}
        </table>
      </div>
    </div>
  </div>
</div>