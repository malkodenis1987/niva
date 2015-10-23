timely.define(["jquery_timely"],function(e){var t=function(e){this.value={h:1,s:1,b:1,a:1},this.setColor(e)};t.prototype={constructor:t,setColor:function(t){t=t.toLowerCase();var n=this;e.each(r.stringParsers,function(e,i){var s=i.re.exec(t),o=s&&i.parse(s),u=i.space||"rgba";if(o)return u=="hsla"?n.value=r.RGBtoHSB.apply(null,r.HSLtoRGB.apply(null,o)):n.value=r.RGBtoHSB.apply(null,o),!1})},setHue:function(e){this.value.h=1-e},setSaturation:function(e){this.value.s=e},setLightness:function(e){this.value.b=1-e},setAlpha:function(e){this.value.a=parseInt((1-e)*100,10)/100},toRGB:function(e,t,n,r){e||(e=this.value.h,t=this.value.s,n=this.value.b),e*=360;var i,s,o,u,a;return e=e%360/60,a=n*t,u=a*(1-Math.abs(e%2-1)),i=s=o=n-a,e=~~e,i+=[a,u,0,0,u,a][e],s+=[u,a,a,u,0,0][e],o+=[0,0,u,a,a,u][e],{r:Math.round(i*255),g:Math.round(s*255),b:Math.round(o*255),a:r||this.value.a}},toHex:function(e,t,n,r){var i=this.toRGB(e,t,n,r);return"#"+(1<<24|parseInt(i.r)<<16|parseInt(i.g)<<8|parseInt(i.b)).toString(16).substr(1)},toHSL:function(e,t,n,r){e||(e=this.value.h,t=this.value.s,n=this.value.b);var i=e,s=(2-t)*n,o=t*n;return s>0&&s<=1?o/=s:o/=2-s,s/=2,o>1&&(o=1),{h:i,s:o,l:s,a:r||this.value.a}}};var n=function(t,n){this.element=e(t);var i=n.format||this.element.data("color-format")||"hex";this.format=r.translateFormats[i],this.isInput=this.element.is("input"),this.component=this.element.is(".color")?this.element.find(".ai1ec-input-group-addon"):!1,this.picker=e(r.template).appendTo("body").on("mousedown",e.proxy(this.mousedown,this)),this.isInput?this.element.on({focus:e.proxy(this.show,this),keyup:e.proxy(this.update,this)}):this.component?this.component.on({click:e.proxy(this.show,this)}):this.element.on({click:e.proxy(this.show,this)});if(i=="rgba"||i=="hsla")this.picker.addClass("alpha"),this.alpha=this.picker.find(".colorpicker-alpha")[0].style;this.component?(this.picker.find(".colorpicker-color").hide(),this.preview=this.element.find("i")[0].style):this.preview=this.picker.find("div:last")[0].style,this.base=this.picker.find("div:first")[0].style,this.update()};n.prototype={constructor:n,show:function(t){this.picker.show(),this.height=this.component?this.component.outerHeight():this.element.outerHeight(),this.place(),e(window).on("resize",e.proxy(this.place,this)),this.isInput||t&&(t.stopPropagation(),t.preventDefault()),e(document).on({mousedown:e.proxy(this.hide,this)}),this.element.trigger({type:"show",color:this.color})},update:function(){this.color=new t(this.isInput?this.element.prop("value"):this.element.data("color")),this.picker.find("i").eq(0).css({left:this.color.value.s*100,top:100-this.color.value.b*100}).end().eq(1).css("top",100*(1-this.color.value.h)).end().eq(2).css("top",100*(1-this.color.value.a)),this.previewColor()},hide:function(){this.picker.hide(),e(window).off("resize",this.place),this.isInput?this.element.prop("value",this.format.call(this)):(e(document).off({mousedown:this.hide}),this.component&&this.element.find("input").prop("value",this.format.call(this)),this.element.data("color",this.format.call(this))),this.element.trigger({type:"hide",color:this.color})},place:function(){var e=this.component?this.component.offset():this.element.offset();this.picker.css({top:e.top+this.height,left:e.left})},previewColor:function(){this.preview.backgroundColor=this.format.call(this),this.base.backgroundColor=this.color.toHex(this.color.value.h,1,1,1),this.alpha&&(this.alpha.backgroundColor=this.color.toHex())},pointer:null,slider:null,mousedown:function(t){t.stopPropagation(),t.preventDefault();var n=e(t.target),i=n.closest("div");if(!i.is(".colorpicker")){i.is(".colorpicker-saturation")?this.slider=e.extend({},r.sliders.saturation):i.is(".colorpicker-hue")?this.slider=e.extend({},r.sliders.hue):i.is(".colorpicker-alpha")&&(this.slider=e.extend({},r.sliders.alpha));var s=i.offset();this.slider.knob=i.find("i")[0].style,this.slider.left=t.pageX-s.left,this.slider.top=t.pageY-s.top,this.pointer={left:t.pageX,top:t.pageY},e(document).on({mousemove:e.proxy(this.mousemove,this),mouseup:e.proxy(this.mouseup,this)}).trigger("mousemove")}return!1},mousemove:function(e){e.stopPropagation(),e.preventDefault();var t=Math.max(0,Math.min(this.slider.maxLeft,this.slider.left+((e.pageX||this.pointer.left)-this.pointer.left))),n=Math.max(0,Math.min(this.slider.maxTop,this.slider.top+((e.pageY||this.pointer.top)-this.pointer.top)));return this.slider.knob.left=t+"px",this.slider.knob.top=n+"px",this.slider.callLeft&&this.color[this.slider.callLeft].call(this.color,t/100),this.slider.callTop&&this.color[this.slider.callTop].call(this.color,n/100),this.previewColor(),this.element.trigger({type:"changeColor",color:this.color}),!1},mouseup:function(t){return t.stopPropagation(),t.preventDefault(),e(document).off({mousemove:this.mousemove,mouseup:this.mouseup}),!1}},e.fn.colorpicker=function(t){return this.each(function(){var r=e(this),i=r.data("colorpicker"),s=typeof t=="object"&&t;i||r.data("colorpicker",i=new n(this,e.extend({},e.fn.colorpicker.defaults,s))),typeof t=="string"&&i[t]()})},e.fn.colorpicker.defaults={},e.fn.colorpicker.Constructor=n;var r={translateFormats:{rgb:function(){var e=this.color.toRGB();return"rgb("+e.r+","+e.g+","+e.b+")"},rgba:function(){var e=this.color.toRGB();return"rgba("+e.r+","+e.g+","+e.b+","+e.a+")"},hsl:function(){var e=this.color.toHSL();return"hsl("+Math.round(e.h*360)+","+Math.round(e.s*100)+"%,"+Math.round(e.l*100)+"%)"},hsla:function(){var e=this.color.toHSL();return"hsla("+Math.round(e.h*360)+","+Math.round(e.s*100)+"%,"+Math.round(e.l*100)+"%,"+e.a+")"},hex:function(){return this.color.toHex()}},sliders:{saturation:{maxLeft:100,maxTop:100,callLeft:"setSaturation",callTop:"setLightness"},hue:{maxLeft:0,maxTop:100,callLeft:!1,callTop:"setHue"},alpha:{maxLeft:0,maxTop:100,callLeft:!1,callTop:"setAlpha"}},RGBtoHSB:function(e,t,n,r){e/=255,t/=255,n/=255;var i,s,o,u;return o=Math.max(e,t,n),u=o-Math.min(e,t,n),i=u==0?null:o==e?(t-n)/u:o==t?(n-e)/u+2:(e-t)/u+4,i=(i+360)%6*60/360,s=u==0?0:u/o,{h:i||1,s:s,b:o,a:r||1}},HueToRGB:function(e,t,n){return n<0?n+=1:n>1&&(n-=1),n*6<1?e+(t-e)*n*6:n*2<1?t:n*3<2?e+(t-e)*(2/3-n)*6:e},HSLtoRGB:function(e,t,n,i){t<0&&(t=0);if(n<=.5)var s=n*(1+t);else var s=n+t-n*t;var o=2*n-s,u=e+1/3,a=e,f=e-1/3,l=Math.round(r.HueToRGB(o,s,u)*255),c=Math.round(r.HueToRGB(o,s,a)*255),h=Math.round(r.HueToRGB(o,s,f)*255);return[l,c,h,i||1]},stringParsers:[{re:/rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,parse:function(e){return[e[1],e[2],e[3],e[4]]}},{re:/rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,parse:function(e){return[2.55*e[1],2.55*e[2],2.55*e[3],e[4]]}},{re:/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,parse:function(e){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}},{re:/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,parse:function(e){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}},{re:/hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,space:"hsla",parse:function(e){return[e[1]/360,e[2]/100,e[3]/100,e[4]]}}],template:'<div class="colorpicker ai1ec-dropdown-menu"><div class="colorpicker-saturation"><i><b></b></i></div><div class="colorpicker-hue"><i></i></div><div class="colorpicker-alpha"><i></i></div><div class="colorpicker-color"><div /></div></div>'}});