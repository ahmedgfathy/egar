{strip}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <meta name="theme-color" content="#10251c"/>
  <title>Create filter · EGAR CRM</title>
  {literal}
  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700&display=swap');
    :root{font-family:'DM Sans',sans-serif;color:#17251e;background:#f4f7f5}
    *{box-sizing:border-box}
    body{margin:0;background:#f4f7f5}
    .filter-app{min-height:100vh}
    .filter-sidebar{position:fixed;inset:0 auto 0 0;width:250px;padding:24px 17px;background:#10291e;color:#fff}
    .brand{display:flex;align-items:center;gap:12px;margin-bottom:28px;padding:0 8px}
    .brand span{display:grid;place-items:center;width:42px;height:42px;border:1px solid #41604f;border-radius:12px;background:#1c3c2c}
    .brand strong{display:block;font:700 21px 'Manrope';letter-spacing:.08em}
    .brand small{color:#8ca799;font-size:12px;text-transform:uppercase}
    .filter-sidebar nav{display:grid;gap:6px}
    .filter-sidebar a{display:flex;align-items:center;gap:10px;padding:12px;border-radius:10px;color:#c7d7cf;font-size:15px;text-decoration:none}
    .filter-sidebar a:hover,.filter-sidebar a.active{background:#214534;color:#fff}
    .side-note{position:absolute;right:17px;bottom:24px;left:17px;padding:16px;border:1px solid #2d4d3c;border-radius:13px;background:#173627;color:#9fbaaa;font-size:13px;line-height:1.55}
    .filter-main{min-height:100vh;margin-left:250px}
    .filter-topbar{display:flex;align-items:center;justify-content:space-between;height:72px;padding:0 36px;border-bottom:1px solid #dfe7e2;background:#fff}
    .crumbs{display:flex;gap:9px;color:#7d8b83;font-size:14px}
    .crumbs a{color:#356b52;text-decoration:none}
    .back-link{color:#356b52;font-size:14px;font-weight:700;text-decoration:none}
    .filter-content{max-width:1180px;padding:34px 36px 60px}
    .hero{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:24px}
    .eyebrow{color:#397458;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase}
    h1{margin:8px 0 6px;font:700 40px 'Manrope'}
    .hero p{margin:0;color:#728078;font-size:16px;line-height:1.55}
    .save-button{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:0 18px;border:0;border-radius:11px;background:#0f4b35;color:#fff;font:700 15px 'DM Sans';cursor:pointer}
    .builder{overflow:hidden;border:1px solid #dfe6e1;border-radius:15px;background:#fff;box-shadow:0 4px 16px #173d2b0a}
    .section{padding:24px;border-bottom:1px solid #edf1ee}
    .section:last-child{border-bottom:0}
    .section h2{margin:0 0 16px;font:700 20px 'Manrope'}
    .field-row{display:grid;grid-template-columns:minmax(260px,1fr) repeat(3,auto);align-items:center;gap:18px}
    label{color:#304139;font-size:15px;font-weight:700}
    input[type=text],select{width:100%;min-height:46px;padding:0 13px;border:1px solid #dce4df;border-radius:10px;background:#fff;color:#17251e;font:600 15px 'DM Sans'}
    .check{display:flex;align-items:center;gap:8px;color:#536259;font-size:14px;font-weight:600}
    .check input{width:18px;height:18px;accent-color:#0f4b35}
    .columns-layout{display:grid;grid-template-columns:minmax(280px,1fr) 300px;gap:20px}
    .column-picker{min-height:390px;padding:12px;border:1px solid #dce4df;border-radius:12px;background:#fbfdfb;font-size:15px}
    .condition-grid{display:grid;grid-template-columns:minmax(240px,1fr) 190px minmax(220px,1fr);gap:12px}
    .hint-card{padding:18px;border:1px solid #dce4df;border-radius:12px;background:#f7faf8;color:#5d6d64;font-size:14px;line-height:1.65}
    .hint-card strong{display:block;margin-bottom:8px;color:#24392f;font-size:16px}
    .status{display:none;margin:16px 0 0;padding:13px 15px;border-radius:10px;font-size:15px}
    .status.error{display:block;border:1px solid #efc3bd;background:#fff3f1;color:#9a3734}
    .status.success{display:block;border:1px solid #b8dbc5;background:#effaf2;color:#24613f}
    .actions{display:flex;align-items:center;justify-content:flex-end;gap:12px;padding:20px 24px;background:#fbfdfb}
    .cancel{color:#456855;font-size:15px;font-weight:700;text-decoration:none}
    @media(max-width:900px){.filter-sidebar{display:none}.filter-main{margin-left:0}.filter-topbar{padding:0 18px}.filter-content{padding:25px 18px}.hero,.field-row{display:grid}.columns-layout,.condition-grid{grid-template-columns:1fr}h1{font-size:34px}}
  </style>
  {/literal}
</head>
<body>
  <div class="filter-app">
    <aside class="filter-sidebar">
      <div class="brand"><span>F</span><div><strong>EGAR</strong><small>Filter builder</small></div></div>
      <nav>
        <a href="index.php?module=Vtiger&view=ReactDashboard">Dashboard</a>
        <a class="active" href="#">Create filter</a>
        <a href="{$BACK_URL}">Back to {$SOURCE_MODULE_LABEL}</a>
      </nav>
      <div class="side-note">Choose the columns users need every day. After saving, the module list opens with the new filter selected.</div>
    </aside>
    <main class="filter-main">
      <header class="filter-topbar">
        <div class="crumbs"><a href="index.php?module=Vtiger&view=ReactDashboard">Workspace</a><span>/</span><strong>{$SOURCE_MODULE_LABEL}</strong><span>/</span><strong>Create filter</strong></div>
        <a class="back-link" href="{$BACK_URL}">Back to list</a>
      </header>
      <div class="filter-content">
        <section class="hero">
          <div><span class="eyebrow">Saved view</span><h1>Create filter</h1><p>Build a clean saved filter for {$SOURCE_MODULE_LABEL}. Pick the columns, choose visibility, then save it directly into vtiger.</p></div>
          <button class="save-button" form="reactFilterForm" type="submit">Save filter</button>
        </section>
        <form id="reactFilterForm" class="builder" method="post" action="index.php">
          <input type="hidden" name="module" value="CustomView"/>
          <input type="hidden" name="action" value="Save"/>
          <input type="hidden" name="source_module" value="{$SOURCE_MODULE}"/>
          <input type="hidden" name="record" value="{$RECORD_ID}"/>
          <input type="hidden" name="columnslist" value=""/>
          <input type="hidden" name="stdfilterlist" value=""/>
          <input type="hidden" name="advfilterlist" value=""/>
          <input type="hidden" name="status" value="{$CV_PRIVATE_VALUE}" data-private="{$CV_PRIVATE_VALUE}" data-public="{$CV_PUBLIC_VALUE}"/>
          <section class="section">
            <h2>Basic details</h2>
            <div class="field-row">
              <label>Filter name<br/><input id="viewname" name="viewname" type="text" maxlength="40" value="{$CUSTOMVIEW_MODEL->get('viewname')}" required/></label>
              <label class="check"><input name="setdefault" type="checkbox" value="1" {if $CUSTOMVIEW_MODEL->isDefault()}checked{/if}/>Set as default</label>
              <label class="check"><input name="setmetrics" type="checkbox" value="1" {if $CUSTOMVIEW_MODEL->get('setmetrics') eq '1'}checked{/if}/>List in metrics</label>
              <label class="check"><input id="publicFilter" type="checkbox" {if $CUSTOMVIEW_MODEL->isSetPublic()}checked{/if}/>Public</label>
            </div>
          </section>
          <section class="section">
            <h2>Columns</h2>
            <div class="columns-layout">
              <select id="viewColumnsSelect" class="column-picker" multiple size="18" aria-label="Filter columns">
                {foreach key=BLOCK_LABEL item=BLOCK_FIELDS from=$RECORD_STRUCTURE}
                  <optgroup label="{vtranslate($BLOCK_LABEL, $SOURCE_MODULE)}">
                    {foreach key=FIELD_NAME item=FIELD_MODEL from=$BLOCK_FIELDS}
                      <option value="{$FIELD_MODEL->getCustomViewColumnName()}" data-mandatory="{if $FIELD_MODEL->isMandatory()}1{else}0{/if}" {if in_array($FIELD_MODEL->getCustomViewColumnName(), $SELECTED_FIELDS)}selected{/if}{if $RECORD_ID eq ''}{if $FIELD_MODEL->isMandatory()} selected{/if}{/if}>{vtranslate($FIELD_MODEL->get('label'), $SOURCE_MODULE)}{if $FIELD_MODEL->isMandatory()} *{/if}</option>
                    {/foreach}
                  </optgroup>
                {/foreach}
              </select>
              <div class="hint-card">
                <strong>Column tips</strong>
                Select up to 12 columns. At least one required field marked with * must stay selected so vtiger can create the filter.
                <br/><br/>
                Hold Ctrl while clicking to select multiple columns.
              </div>
            </div>
            <div id="filterStatus" class="status"></div>
          </section>
          <section class="section">
            <h2>Condition</h2>
            <div class="condition-grid">
              <label>Field<br/><select id="conditionColumn"><option value="">No condition</option></select></label>
              <label>Match<br/><select id="conditionComparator"><option value="c">Contains</option><option value="e">Equals</option><option value="s">Starts with</option><option value="ew">Ends with</option><option value="k">Does not contain</option><option value="n">Not equal</option></select></label>
              <label>Value<br/><input id="conditionValue" type="text" placeholder="Optional filter value"/></label>
            </div>
          </section>
          <div class="actions"><a class="cancel" href="{$BACK_URL}">Cancel</a><button class="save-button" type="submit">Save filter</button></div>
        </form>
      </div>
    </main>
  </div>
  {literal}
  <script>
    (function () {
      var form = document.getElementById('reactFilterForm');
      var select = document.getElementById('viewColumnsSelect');
      var statusBox = document.getElementById('filterStatus');
      var statusInput = form.querySelector('input[name="status"]');
      var publicInput = document.getElementById('publicFilter');
      var columnsInput = form.querySelector('input[name="columnslist"]');
      var advFilterInput = form.querySelector('input[name="advfilterlist"]');
      var conditionColumn = document.getElementById('conditionColumn');
      var conditionComparator = document.getElementById('conditionComparator');
      var conditionValue = document.getElementById('conditionValue');

      Array.prototype.slice.call(select.options).forEach(function (option) {
        if (!option.value) return;
        var clone = document.createElement('option');
        clone.value = option.value;
        clone.textContent = option.textContent.replace(' *', '');
        conditionColumn.appendChild(clone);
      });

      function selectedOptions() {
        return Array.prototype.slice.call(select.options).filter(function (option) { return option.selected; });
      }

      function showStatus(type, message) {
        statusBox.className = 'status ' + type;
        statusBox.textContent = message;
      }

      form.addEventListener('submit', function (event) {
        event.preventDefault();
        var columns = selectedOptions();
        if (!form.viewname.value.trim()) {
          showStatus('error', 'Please enter a filter name.');
          form.viewname.focus();
          return;
        }
        if (columns.length === 0) {
          showStatus('error', 'Please select at least one column.');
          select.focus();
          return;
        }
        if (columns.length > 12) {
          showStatus('error', 'Please select 12 columns or fewer.');
          select.focus();
          return;
        }
        var hasMandatory = columns.some(function (option) { return option.getAttribute('data-mandatory') === '1'; });
        if (!hasMandatory) {
          showStatus('error', 'Please keep at least one required column selected.');
          select.focus();
          return;
        }
        columnsInput.value = JSON.stringify(columns.map(function (option) { return option.value; }));
        if (conditionColumn.value && conditionValue.value.trim()) {
          advFilterInput.value = JSON.stringify({
            1: {
              columns: [{
                columnname: conditionColumn.value,
                comparator: conditionComparator.value,
                value: conditionValue.value.trim(),
                column_condition: ''
              }],
              condition: 'and'
            }
          });
        } else {
          advFilterInput.value = '';
        }
        statusInput.value = publicInput.checked ? statusInput.getAttribute('data-public') : statusInput.getAttribute('data-private');

        var body = new FormData(form);
        if (window.csrfMagicName && window.csrfMagicToken && !body.has(window.csrfMagicName)) {
          body.append(window.csrfMagicName, window.csrfMagicToken);
        }
        showStatus('success', 'Saving filter...');
        fetch('index.php', {
          method: 'POST',
          body: body,
          credentials: 'same-origin',
          headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(function (response) {
          return response.json();
        }).then(function (payload) {
          if (!payload || !payload.success) {
            throw new Error((payload && payload.error && payload.error.message) || 'Unable to save filter.');
          }
          var url = payload.result && payload.result.listviewurl ? payload.result.listviewurl : form.getAttribute('data-back-url');
          window.location.href = url;
        }).catch(function (error) {
          showStatus('error', error.message || 'Unable to save filter.');
        });
      });
    })();
  </script>
  {/literal}
</body>
</html>
{/strip}
