<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 faqs-container">
      <p>
        <h2>{l s='Frequently Asked Questions' mod='camaloon'}</h2>
        <div class="description">
          {l s='Getting started made easy. Read the FAQs to jumpstart your business.' mod='camaloon'}
        </div>
      </p>
      <div class="white-content-box white-content-box-left">
        {foreach key=key item=faq from=$faqs}
            <div class="faq">
              <h2>{$faq["question_{$iso_code}"]}</h2>
              <p>{$faq["answer_{$iso_code}"]}</p>
            </div>
        {/foreach}
      </div>
    </div>
     <div class="col-md-6">
     <p>
        <h2>{l s='Need support? Contact us.' mod='camaloon'}</h2>
        <div class="description">
          {l s='Copy the box content below and add it to your support message Note: this status report may not include an error log. Contact your hosting provider if you need help with acquiring error logs.' mod='camaloon'}
        </div>
      </p>
      <div class="white-content-box white-content-box-left">
        <div id="checklistClipboard" class="support-errors">
          <p>##### {l s='Camaloon Checklist' mod='camaloon'} #####</p>
          {foreach key=key item=item from=$items}
              <tr>
                <p>{$item['name']} => {($item['value'] == 1) ? 'OK' : 'FAIL'}</p>
              </tr>
          {/foreach}
        </div>
        <div class="support-note">
          {l s='Note: this status report may not include an error log. Contact your hosting provider if you need help with acquiring error logs.' mod='camaloon'}
        </div>
        <button class="btn btn-primary" onclick="copyChecklistClipboard()">{l s='Copy' mod='camaloon'}</button>
      </div>
     </div>
  </div>
</div>