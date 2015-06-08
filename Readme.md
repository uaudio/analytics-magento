
# Analytics for Magento

**Analytics for Magento** is a Magento extension for [Segment](https://segment.com) that lets you send data to any analytics tool you want without writing any code yourself!

- [Installing](#installing)

## Installing

Download latest release from https://github.com/uaudio/analytics-magento/releases

In Magento Admin, go to System -> Magento Connect -> Magento Connect Manager.

Then, under "Direct package file upload" upload the file you downloaded

## Built-in Events

The following events are sent by this extension: 
* Logged In
* Logged Out
* Added Product
* Removed Product
* Searched Products
* Signed Up
* Viewed Product Reviews
* Viewed Product
* Subscribed to Newsletter
* Wishlisted Product
* Completed Order

## Add a Custom Event

To add a new event, first override the Segment_Analytics extenstion in your local code pool.

Then add the following: 

**Event observer**
```
	<global>
		<events>
      <MY_EVENT>
        <observers>
          <MY_EVENT_NAME>
            <type>model</type>
            <class>MYMODULE/observer</class>
            <method>MYMETHOD</method>
          </MY_EVENT_NAME>
        </observers>
      </MY_EVENT>
    </events>
  </global>
```

**Observer Method** 
(call addAction or addDeferredAction depending on whether Magento will redirect after the event is fired)
```
    public function MYMETHOD($observer) {
        $this->addDeferredAction('newevent',
            array()
        ,'MYMODULE');
    }
```

**Block for newevent**
```
<?php
class MYMODULE_Block_Newevent extends Mage_Core_Block_Template {
	public function _toHtml() {
        if (!Mage::helper('analytics')->isEnabled()) return false;
        $contextJson = Mage::helper('analytics')->getContextJson();
        $data = Mage::registry('segment_data');
        Mage::unregister('segment_data');
        $json = Mage::helper("core")->jsonEncode($data);
        $json = preg_replace('%[\r\n]%','',$json);
		return '<script>document.observe("dom:loaded", function() { window.analytics.track(\'New Event\','.$json.','.$contextJson.');});</script>';
	}
}
```


## License

Copyright &copy; 2014 Segment &lt;friends@segment.com&gt;

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the 'Software'), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
