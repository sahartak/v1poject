jQuery.fn.hint = function (blurClass) {
    if (!blurClass) {
        blurClass = 'blur';
    }
	
    return this.each(function () {
        // get jQuery version of 'this'
        var $input = jQuery(this),
			
        // capture the rest of the variable to allow for reuse
        title = $input.attr('title'),
        $form = jQuery(this.form),
        $win = jQuery(window);
			
        function remove() {
            if ($input.val() === title && $input.hasClass(blurClass)) {
                $input.val('').removeClass(blurClass);
            }
        }
			
        // only apply logic if the element has the attribute
        if (title) {
            // on blur, set value to title attr if text is blank
            $input.blur(function () {
                if (this.value === '') {
                    $input.val(title).addClass(blurClass);
                }
            }).focus(remove).blur(); // now change all inputs to title
				
            // clear the pre-defined text when form is submitted
            $form.submit(remove);
            $win.unload(remove); // handles Firefox's autocomplete
        }
    });
};

(function(f){f.fn.extend({autocomplete:function(b,c){var i=typeof b=="string";c=f.extend({},f.Autocompleter.defaults,{url:i?b:null,data:i?null:b,delay:i?f.Autocompleter.defaults.delay:10,max:c&&!c.scroll?10:150},c);c.highlight=c.highlight||function(a){return a};c.formatMatch=c.formatMatch||c.formatItem;return this.each(function(){new f.Autocompleter(this,c)})},result:function(a){return this.bind("result",a)},search:function(a){return this.trigger("search",[a])},flushCache:function(){return this.trigger("flushCache")},setOptions:function(a){return this.trigger("setOptions",[a])},unautocomplete:function(){return this.trigger("unautocomplete")}});f.Autocompleter=function(o,e){var h={UP:38,DOWN:40,DEL:46,TAB:9,RETURN:13,ESC:27,COMMA:188,PAGEUP:33,PAGEDOWN:34,BACKSPACE:8};var d=f(o).attr("autocomplete","off").addClass(e.inputClass);var l;var q="";var r=f.Autocompleter.Cache(e);var m=0;var j;var u={mouseDownOnSelect:false};var k=f.Autocompleter.Select(e,o,w,u);var s;f.browser.opera&&f(o.form).bind("submit.autocomplete",function(){if(s){s=false;return false}});d.bind((f.browser.opera?"keypress":"keydown")+".autocomplete",function(a){j=a.keyCode;switch(a.keyCode){case h.UP:a.preventDefault();if(k.visible()){k.prev()}else{t(0,true)}break;case h.DOWN:a.preventDefault();if(k.visible()){k.next()}else{t(0,true)}break;case h.PAGEUP:a.preventDefault();if(k.visible()){k.pageUp()}else{t(0,true)}break;case h.PAGEDOWN:a.preventDefault();if(k.visible()){k.pageDown()}else{t(0,true)}break;case e.multiple&&f.trim(e.multipleSeparator)==","&&h.COMMA:case h.TAB:case h.RETURN:if(w()){a.preventDefault();s=true;return false}break;case h.ESC:k.hide();break;default:clearTimeout(l);l=setTimeout(t,e.delay);break}}).focus(function(){m++}).blur(function(){m=0;if(!u.mouseDownOnSelect){B()}}).click(function(){if(m++>1&&!k.visible()){t(0,true)}}).bind("search",function(){var g=(arguments.length>1)?arguments[1]:null;function n(a,b){var c;if(b&&b.length){for(var i=0;i<b.length;i++){if(b[i].result.toLowerCase()==a.toLowerCase()){c=b[i];break}}}if(typeof g=="function")g(c);else d.trigger("result",c&&[c.data,c.value])}f.each(v(d.val()),function(a,b){A(b,n,n)})}).bind("flushCache",function(){r.flush()}).bind("setOptions",function(){f.extend(e,arguments[1]);if("data"in arguments[1])r.populate()}).bind("unautocomplete",function(){k.unbind();d.unbind();f(o.form).unbind(".autocomplete")});function w(){var a=k.selected();if(!a)return false;var b=a.result;q=b;if(e.multiple){var c=v(d.val());if(c.length>1){b=c.slice(0,c.length-1).join(e.multipleSeparator)+e.multipleSeparator+b}b+=e.multipleSeparator}d.val(b);x();d.trigger("result",[a.data,a.value]);return true}function t(a,b){if(j==h.DEL){k.hide();return}var c=d.val();if(!b&&c==q)return;q=c;c=y(c);if(c.length>=e.minChars){d.addClass(e.loadingClass);if(!e.matchCase)c=c.toLowerCase();A(c,C,x)}else{z();k.hide()}};function v(c){if(!c){return[""]}var i=c.split(e.multipleSeparator);var g=[];f.each(i,function(a,b){if(f.trim(b))g[a]=f.trim(b)});return g}function y(a){if(!e.multiple)return a;var b=v(a);return b[b.length-1]}function D(a,b){if(e.autoFill&&(y(d.val()).toLowerCase()==a.toLowerCase())&&j!=h.BACKSPACE){d.val(d.val()+b.substring(y(q).length));f.Autocompleter.Selection(o,q.length,q.length+b.length)}};function B(){clearTimeout(l);l=setTimeout(x,200)};function x(){var c=k.visible();k.hide();clearTimeout(l);z();if(e.mustMatch){d.search(function(a){if(!a){if(e.multiple){var b=v(d.val()).slice(0,-1);d.val(b.join(e.multipleSeparator)+(b.length?e.multipleSeparator:""))}else d.val("")}})}if(c)f.Autocompleter.Selection(o,o.value.length,o.value.length)};function C(a,b){if(b&&b.length&&m){z();k.display(b,a);D(a,b[0].value);k.show()}else{x()}};function A(c,i,g){if(!e.matchCase)c=c.toLowerCase();var n=r.load(c);if(n&&n.length){i(c,n)}else if((typeof e.url=="string")&&(e.url.length>0)){var p={timestamp:+new Date()};f.each(e.extraParams,function(a,b){p[a]=typeof b=="function"?b():b});f.ajax({mode:"abort",port:"autocomplete"+o.name,dataType:e.dataType,url:e.url,data:f.extend({q:y(c),limit:e.max},p),success:function(a){var b=e.parse&&e.parse(a)||E(a);r.add(c,b);i(c,b)}})}else{k.emptyList();g(c)}};function E(a){var b=[];var c=a.split("\n");for(var i=0;i<c.length;i++){var g=f.trim(c[i]);if(g){g=g.split("|");b[b.length]={data:g,value:g[0],result:e.formatResult&&e.formatResult(g,g[0])||g[0]}}}return b};function z(){d.removeClass(e.loadingClass)}};f.Autocompleter.defaults={inputClass:"ac_input",resultsClass:"ac_results",loadingClass:"ac_loading",minChars:1,delay:400,matchCase:false,matchSubset:true,matchContains:false,cacheLength:10,max:100,mustMatch:false,extraParams:{},selectFirst:true,formatItem:function(a){return a[0]},formatMatch:null,autoFill:false,width:0,multiple:false,multipleSeparator:", ",highlight:function(a,b){return a.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+b.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>")},scroll:true,scrollHeight:180};f.Autocompleter.Cache=function(d){var l={};var q=0;function r(a,b){if(!d.matchCase)a=a.toLowerCase();var c=a.indexOf(b);if(c==-1)return false;return c==0||d.matchContains};function m(a,b){if(q>d.cacheLength){u()}if(!l[a]){q++}l[a]=b}function j(){if(!d.data)return false;var c={},i=0;if(!d.url)d.cacheLength=1;c[""]=[];for(var g=0,n=d.data.length;g<n;g++){var p=d.data[g];p=(typeof p=="string")?[p]:p;var o=d.formatMatch(p,g+1,d.data.length);if(o===false)continue;var e=o.charAt(0).toLowerCase();if(!c[e])c[e]=[];var h={value:o,data:p,result:d.formatResult&&d.formatResult(p)||o};c[e].push(h);if(i++<d.max){c[""].push(h)}};f.each(c,function(a,b){d.cacheLength++;m(a,b)})}setTimeout(j,25);function u(){l={};q=0}return{flush:u,add:m,populate:j,load:function(c){if(!d.cacheLength||!q)return null;if(!d.url&&d.matchContains){var i=[];for(var g in l){if(g.length>0){var n=l[g];f.each(n,function(a,b){if(r(b.value,c)){i.push(b)}})}}return i}else if(l[c]){return l[c]}else if(d.matchSubset){for(var p=c.length-1;p>=d.minChars;p--){var n=l[c.substr(0,p)];if(n){var i=[];f.each(n,function(a,b){if(r(b.value,c)){i[i.length]=b}});return i}}}return null}}};f.Autocompleter.Select=function(g,n,p,o){var e={ACTIVE:"ac_over"};var h,d=-1,l,q="",r=true,m,j;function u(){if(!r)return;m=f("<div/>").hide().addClass(g.resultsClass).css("position","absolute").appendTo(document.body);j=f("<ul/>").appendTo(m).mouseover(function(a){if(k(a).nodeName&&k(a).nodeName.toUpperCase()=='LI'){d=f("li",j).removeClass(e.ACTIVE).index(k(a));f(k(a)).addClass(e.ACTIVE)}}).click(function(a){f(k(a)).addClass(e.ACTIVE);p();n.focus();return false}).mousedown(function(){o.mouseDownOnSelect=true}).mouseup(function(){o.mouseDownOnSelect=false});if(g.width>0)m.css("width",g.width);r=false}function k(a){var b=a.target;while(b&&b.tagName!="LI")b=b.parentNode;if(!b)return[];return b}function s(a){h.slice(d,d+1).removeClass(e.ACTIVE);w(a);var b=h.slice(d,d+1).addClass(e.ACTIVE);if(g.scroll){var c=0;h.slice(0,d).each(function(){c+=this.offsetHeight});if((c+b[0].offsetHeight-j.scrollTop())>j[0].clientHeight){j.scrollTop(c+b[0].offsetHeight-j.innerHeight())}else if(c<j.scrollTop()){j.scrollTop(c)}}};function w(a){d+=a;if(d<0){d=h.size()-1}else if(d>=h.size()){d=0}}function t(a){return g.max&&g.max<a?g.max:a}function v(){j.empty();var a=t(l.length);for(var b=0;b<a;b++){if(!l[b])continue;var c=g.formatItem(l[b].data,b+1,a,l[b].value,q);if(c===false)continue;var i=f("<li/>").html(g.highlight(c,q)).addClass(b%2==0?"ac_even":"ac_odd").appendTo(j)[0];f.data(i,"ac_data",l[b])}h=j.find("li");if(g.selectFirst){h.slice(0,1).addClass(e.ACTIVE);d=0}if(f.fn.bgiframe)j.bgiframe()}return{display:function(a,b){u();l=a;q=b;v()},next:function(){s(1)},prev:function(){s(-1)},pageUp:function(){if(d!=0&&d-8<0){s(-d)}else{s(-8)}},pageDown:function(){if(d!=h.size()-1&&d+8>h.size()){s(h.size()-1-d)}else{s(8)}},hide:function(){m&&m.hide();h&&h.removeClass(e.ACTIVE);d=-1},visible:function(){return m&&m.is(":visible")},current:function(){return this.visible()&&(h.filter("."+e.ACTIVE)[0]||g.selectFirst&&h[0])},show:function(){var a=f(n).offset();m.css({width:typeof g.width=="string"||g.width>0?g.width:f(n).width(),top:a.top+n.offsetHeight,left:a.left}).show();if(g.scroll){j.scrollTop(0);j.css({maxHeight:g.scrollHeight,overflow:'auto'});if(f.browser.msie&&typeof document.body.style.maxHeight==="undefined"){var b=0;h.each(function(){b+=this.offsetHeight});var c=b>g.scrollHeight;j.css('height',c?g.scrollHeight:b);if(!c){h.width(j.width()-parseInt(h.css("padding-left"))-parseInt(h.css("padding-right")))}}}},selected:function(){var a=h&&h.filter("."+e.ACTIVE).removeClass(e.ACTIVE);return a&&a.length&&f.data(a[0],"ac_data")},emptyList:function(){j&&j.empty()},unbind:function(){m&&m.remove()}}};f.Autocompleter.Selection=function(a,b,c){if(a.createTextRange){var i=a.createTextRange();i.collapse(true);i.moveStart("character",b);i.moveEnd("character",c);i.select()}else if(a.setSelectionRange){a.setSelectionRange(b,c)}else{if(a.selectionStart){a.selectionStart=b;a.selectionEnd=c}}a.focus()}})(jQuery);

function stopTableSorting(e) {
	if (!e) var e = window.event
	e.cancelBubble = true;
	if (e.stopPropagation) e.stopPropagation();
}

function jFormat(val,dec) {
	if (dec < 0) {
		val = parseFloat(val) + '';
		dd = val.split('.');
		ll = dd[1] ? dd[1].length : 2;
		dec = (ll<2) ? ll : 2;
		dec = (ll<7) ? ll : 7;
	}
	val = parseFloat(val).toFixed(dec);
	x = val.split('.');

	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	val = x1 + x2;
	return val;
}

function jNum(val) {
	var val = val.replace(/[^0-9.]/g,'');
	val = val ? val : 0;
	return val;
}

jQuery(document).ready(function($){
	$("input:text").hint();
});