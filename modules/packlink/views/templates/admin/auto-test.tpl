{**
 * 2020 Packlink
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache License 2.0
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @author    Packlink <support@packlink.com>
 * @copyright 2020 Packlink Shipping S.L
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt  Apache License 2.0
 *}

<div class="container-fluid pl-main-wrapper" id="pl-main-page-holder">
  <div class="col-sm-2 pl-logo-wrapper">
    <img src="{html_entity_decode($dashboardLogo|escape:'html':'UTF-8')}"
         class="pl-dashboard-logo"
         alt="{l s='Packlink PRO Shipping' mod='packlink'}">
  </div>
  <div class="col-sm-12 pl-auto-test-panel">
    <div class="pl-auto-test-header">
      <div class="pl-auto-test-title">
          {l s='PacklinkPRO module auto-test' mod='packlink'}
      </div>
      <div class="pl-auto-test-subtitle">
          {l s='Use this page to test the system configuration and PacklinkPRO module services.' mod='packlink'}
      </div>
    </div>

    <div class="pl-auto-test-content col-10" id="pl-auto-test-progress">
      <button type="button" name="start-test" id="pl-auto-test-start"
              class="btn btn-primary btn-lg">{l s='Start' mod='packlink'}</button>
      <div class="pl-auto-test-log-panel" id="pl-auto-test-log-panel">
        ...
      </div>
    </div>
    <div class="pl-auto-test-content" id="pl-spinner-box">
      <div class="pl-spinner" id="pl-spinner">
        <div></div>
      </div>
    </div>

    <div class="pl-auto-test-content" id="pl-auto-test-done">
      <div class="pl-auto-test-content col-10">
        <div class="pl-flash-msg success" id="pl-flash-message-success">
          <div class="pl-flash-msg-text-section">
            <i class="material-icons success">
              check_circle
            </i>
            <span id="pl-flash-message-text">{l s='Auto-test passed successfully!' mod='packlink'}</span>
          </div>
        </div>
        <div class="pl-flash-msg danger" id="pl-flash-message-fail">
          <div class="pl-flash-msg-text-section">
            <i class="material-icons danger">
              error
            </i>
            <span id="pl-flash-message-text">{l s='The test did not complete successfully.' mod='packlink'}</span>
          </div>
        </div>
      </div>

      <a href="{$downloadLogUrl}" value="auto-test-log.json" download>
        <button type="button" name="download-log"
                class="btn btn-info btn-lg">{l s='Download test log' mod='packlink'}</button>
      </a>
      <a href="{$systemInfoUrl}" value="packlink-debug-data.zip" download>
        <button type="button" name="download-system-info-file"
                class="btn btn-info btn-lg">{l s='Download system info file' mod='packlink'}</button>
      </a>
      <a href="{$moduleUrl}">
        <button type="button" name="open-module"
                class="btn btn-success btn-lg">{l s='Open PacklinkPRO module' mod='packlink'}</button>
      </a>

    </div>
  </div>
</div>

<script type="application/javascript">
    hidePrestaSpinner();
    Packlink.AutoTestController("{$startTestUrl}", "{$checkStatusUrl}");
</script>
