{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    Apply Novation (Artem Zwinger)
*  @copyright 2016-2019 Apply Novation
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
<style>
    #ansuggestions .panel-body {
        display: flex;
        justify-content: space-between;
        padding: 0;
    }
    #ansuggestions .suggestions-item {
        position: relative;
        border-radius: 5px;
        width: 33%;
		padding: 32px 45px 32px 45px;
        overflow: hidden;
    }
    #ansuggestions .suggestions-item_blue {
        background-color: #d9edf6;
        -webkit-box-shadow: 0px 5px 0px 0px #b9dced;
        -moz-box-shadow: 0px 5px 0px 0px #b9dced;
        box-shadow: 0px 5px 0px 0px #b9dced;   
    }
    #ansuggestions .suggestions-item_green {
        background-color: #ddf0dd;
        -webkit-box-shadow: 0px 5px 0px 0px #c0e2c0;
        -moz-box-shadow: 0px 5px 0px 0px #c0e2c0;
        box-shadow: 0px 5px 0px 0px #c0e2c0; 
    }
    #ansuggestions .suggestions-item_yellow {
        background-color: #fef6d2;
        -webkit-box-shadow: 0px 5px 0px 0px #fdedad;
        -moz-box-shadow: 0px 5px 0px 0px #fdedad;
        box-shadow: 0px 5px 0px 0px #fdedad; 
    }
    #ansuggestions .suggestions-title {
        margin-bottom: 20px;
        margin-top: 0;
        font-family: 'Open Sans';
        font-size: 24px;
        line-height: 24px;
        color: #000000;
    }
    #ansuggestions .suggestions-desc {
        font-size: 13px;
        line-height: 24px;
        color: #545454;
    }
    #ansuggestions .suggestions-link {
        text-decoration: underline;
    }
	#ansuggestions .suggestions-link:hover {
	  text-decoration: none;
	}
    @media (max-width: 1200px) {
        #ansuggestions .suggestions-item {
            padding: 32px 25px;
        }
    }
    @media (max-width: 1024px) {
        #ansuggestions .panel-body {
            flex-wrap: wrap;
        }
        #ansuggestions .suggestions-item {
            width: 100%;
            margin-bottom: 15px;
            padding: 45px 25px;
        }
    }

    #ansuggestions-mess .panel-body {
      padding: 0;
    }
</style>

<div id="ansuggestions" class="panel col-lg-12">
    <div class="panel-heading">
        <span>SUGGESTIONS</span>
    </div>
    <div class="panel-body">
        <div class="suggestions-item suggestions-item_blue">
            <h2 class="suggestions-title"><a href="https://goo.gl/TWAJWX">Give feedback</a></h2>
            <p class="suggestions-desc"><a href="https://goo.gl/TWAJWX" class="suggestions-link">Rate the module</a> 5 stars if you are satisfied with it or write what we should improve.</p>
        </div>
        <div class="suggestions-item suggestions-item_green">
            <h2 class="suggestions-title"><a href="https://goo.gl/68DEeS">Support</a></h2>
            <p class="suggestions-desc"><a href="https://goo.gl/68DEeS" class="suggestions-link">Contact us</a> on any question or problem with the module.</p>
        </div>
        <div class="suggestions-item suggestions-item_yellow">
            <h2 class="suggestions-title"><a href="https://goo.gl/bJdULz">What's next?</a></h2>
            <p class="suggestions-desc">Find out how to improve your shop with <a href="https://goo.gl/bJdULz" class="suggestions-link">other modules and themes</a> made by Anvanto.</p>
        </div>
    </div>
</div>
<div class="clearfix"></div>