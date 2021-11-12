!function(){function e(e){return e.name||(e.name=s(e.id.replace(/::.*$/,":").replace(/^:|:$/g,""))),e}var t=!1,i=CKEDITOR.tools.array,s=CKEDITOR.tools.htmlEncode,n=CKEDITOR.tools.createClass({$:function(e,t){var i=this.lang=e.lang.emoji,s=this;this.listeners=[],this.plugin=t,this.editor=e,this.groups=[{name:"people",sectionName:i.groups.people,svgId:"cke4-icon-emoji-2",position:{x:-21,y:0},items:[]},{name:"nature",sectionName:i.groups.nature,svgId:"cke4-icon-emoji-3",position:{x:-42,y:0},items:[]},{name:"food",sectionName:i.groups.food,svgId:"cke4-icon-emoji-4",position:{x:-63,y:0},items:[]},{name:"travel",sectionName:i.groups.travel,svgId:"cke4-icon-emoji-6",position:{x:-42,y:-21},items:[]},{name:"activities",sectionName:i.groups.activities,svgId:"cke4-icon-emoji-5",position:{x:-84,y:0},items:[]},{name:"objects",sectionName:i.groups.objects,svgId:"cke4-icon-emoji-7",position:{x:0,y:-21},items:[]},{name:"symbols",sectionName:i.groups.symbols,svgId:"cke4-icon-emoji-8",position:{x:-21,y:-21},items:[]},{name:"flags",sectionName:i.groups.flags,svgId:"cke4-icon-emoji-9",position:{x:-63,y:-21},items:[]}],this.elements={},e.ui.addToolbarGroup("emoji","insert"),e.ui.add("EmojiPanel",CKEDITOR.UI_PANELBUTTON,{label:"emoji",title:i.title,modes:{wysiwyg:1},editorFocus:0,toolbar:"insert",panel:{css:[CKEDITOR.skin.getPath("editor"),t.path+"skins/default.css"],attributes:{role:"listbox","aria-label":i.title},markFirst:!1},onBlock:function(t,i){var n=i.keys,o="rtl"===e.lang.dir;n[o?37:39]="next",n[40]="next",n[9]="next",n[o?39:37]="prev",n[38]="prev",n[CKEDITOR.SHIFT+9]="prev",n[32]="click",s.blockElement=i.element,s.emojiList=s.editor._.emoji.list,s.addEmojiToGroups(),i.element.getAscendant("html").addClass("cke_emoji"),i.element.getDocument().appendStyleSheet(CKEDITOR.getUrl(CKEDITOR.basePath+"contents.css")),i.element.addClass("cke_emoji-panel_block"),i.element.setHtml(s.createEmojiBlock()),i.element.removeAttribute("title"),t.element.addClass("cke_emoji-panel"),s.items=i._.getItems(),s.blockObject=i,s.elements.emojiItems=i.element.find(".cke_emoji-outer_emoji_block li > a"),s.elements.sectionHeaders=i.element.find(".cke_emoji-outer_emoji_block h2"),s.elements.input=i.element.findOne("input"),s.inputIndex=s.getItemIndex(s.items,s.elements.input),s.elements.emojiBlock=i.element.findOne(".cke_emoji-outer_emoji_block"),s.elements.navigationItems=i.element.find("nav li"),s.elements.statusIcon=i.element.findOne(".cke_emoji-status_icon"),s.elements.statusDescription=i.element.findOne("p.cke_emoji-status_description"),s.elements.statusName=i.element.findOne("p.cke_emoji-status_full_name"),s.elements.sections=i.element.find("section"),s.registerListeners()},onOpen:s.openReset()})},proto:{registerListeners:function(){i.forEach(this.listeners,(function(e){var t=e.listener,s=e.event,n=e.ctx||this;i.forEach(this.blockElement.find(e.selector).toArray(),(function(e){e.on(s,t,n)}))}),this)},createEmojiBlock:function(){var e=[];return this.loadSVGNavigationIcons(),e.push(this.createGroupsNavigation()),e.push(this.createSearchSection()),e.push(this.createEmojiListBlock()),e.push(this.createStatusBar()),'<div class="cke_emoji-inner_panel">'+e.join("")+"</div>"},createGroupsNavigation:function(){var e,t;return this.editor.plugins.emoji.isSVGSupported()?(t=CKEDITOR.env.safari?'xlink:href="#{svgId}"':'href="#{svgId}"',e=new CKEDITOR.template('<li class="cke_emoji-navigation_item" data-cke-emoji-group="{group}"><a href="#" title="{name}" draggable="false" _cke_focus="1"><svg viewBox="0 0 34 34" aria-labelledby="{svgId}-title"><title id="{svgId}-title">{name}</title><use '+t+"></use></svg></a></li>"),t=i.reduce(this.groups,(function(t,i){return i.items.length?t+e.output({group:s(i.name),name:s(i.sectionName),svgId:s(i.svgId),translateX:i.translate&&i.translate.x?s(i.translate.x):0,translateY:i.translate&&i.translate.y?s(i.translate.y):0}):t}),"")):(t=CKEDITOR.getUrl(this.plugin.path+"assets/iconsall.png"),e=new CKEDITOR.template('<li class="cke_emoji-navigation_item" data-cke-emoji-group="{group}"><a href="#" draggable="false" _cke_focus="1" title="{name}"><span style="background-image:url('+t+');background-repeat:no-repeat;background-position:{positionX}px {positionY}px;"></span></a></li>'),t=i.reduce(this.groups,(function(t,i){return i.items.length?t+e.output({group:s(i.name),name:s(i.sectionName),positionX:i.position.x,positionY:i.position.y}):t}),"")),this.listeners.push({selector:"nav",event:"click",listener:function(e){var t=e.data.getTarget().getAscendant("li",!0);t&&(i.forEach(this.elements.navigationItems.toArray(),(function(e){e.equals(t)?e.addClass("active"):e.removeClass("active")})),this.clearSearchAndMoveFocus(t),e.data.preventDefault())}}),'<nav aria-label="'+s(this.lang.navigationLabel)+'"><ul>'+t+"</ul></nav>"},createSearchSection:function(){return this.listeners.push({selector:"input",event:"input",listener:CKEDITOR.tools.throttle(200,this.filter,this).input}),this.listeners.push({selector:"input",event:"click",listener:function(){this.blockObject._.markItem(this.inputIndex)}}),'<label class="cke_emoji-search">'+this.getLoupeIcon()+'<input placeholder="'+s(this.lang.searchPlaceholder)+'" type="search" aria-label="'+s(this.lang.searchLabel)+'" role="search" _cke_focus="1"></label>'},createEmojiListBlock:function(){return this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"scroll",listener:CKEDITOR.tools.throttle(150,this.refreshNavigationStatus,this).input}),this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"click",listener:function(e){e.data.getTarget().data("cke-emoji-name")&&this.editor.execCommand("insertEmoji",{emojiText:e.data.getTarget().data("cke-emoji-symbol")})}}),this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"mouseover",listener:function(e){this.updateStatusbar(e.data.getTarget())}}),this.listeners.push({selector:".cke_emoji-outer_emoji_block",event:"keyup",listener:function(){this.updateStatusbar(this.items.getItem(this.blockObject._.focusIndex))}}),'<div class="cke_emoji-outer_emoji_block">'+this.getEmojiSections()+"</div>"},createStatusBar:function(){return'<div class="cke_emoji-status_bar"><div class="cke_emoji-status_icon"></div><p class="cke_emoji-status_description"></p><p class="cke_emoji-status_full_name"></p></div>'},getLoupeIcon:function(){var e=CKEDITOR.getUrl(this.plugin.path+"assets/iconsall.png");return this.editor.plugins.emoji.isSVGSupported()?'<svg viewBox="0 0 34 34" role="img" aria-hidden="true" class="cke_emoji-search_loupe"><use '+(e=CKEDITOR.env.safari?'xlink:href="#cke4-icon-emoji-10"':'href="#cke4-icon-emoji-10"')+"></use></svg>":'<span class="cke_emoji-search_loupe" aria-hidden="true" style="background-image:url('+e+');"></span>'},getEmojiSections:function(){return i.reduce(this.groups,(function(e,t){return t.items.length?e+this.getEmojiSection(t):e}),"",this)},getEmojiSection:function(e){var t=s(e.name);return'<section data-cke-emoji-group="'+t+'" ><h2 id="'+t+'">'+s(e.sectionName)+"</h2><ul>"+(e=this.getEmojiListGroup(e.items))+"</ul></section>"},getEmojiListGroup:function(t){var n=new CKEDITOR.template('<li class="cke_emoji-item"><a draggable="false" data-cke-emoji-full-name="{id}" data-cke-emoji-name="{name}" data-cke-emoji-symbol="{symbol}" data-cke-emoji-group="{group}" data-cke-emoji-keywords="{keywords}" title="{name}" href="#" _cke_focus="1">{symbol}</a></li>');return i.reduce(t,(function(t,i){return e(i),t+n.output({symbol:s(i.symbol),id:s(i.id),name:i.name,group:s(i.group),keywords:s((i.keywords||[]).join(","))})}),"",this)},filter:function(e){var t={},s="string"==typeof e?e:e.sender.getValue();i.forEach(this.elements.emojiItems.toArray(),(function(e){var i;e:{i=e.data("cke-emoji-name");var n=e.data("cke-emoji-keywords");if(-1!==i.indexOf(s))i=!0;else{if(n)for(i=n.split(","),n=0;n<i.length;n++)if(-1!==i[n].indexOf(s)){i=!0;break e}i=!1}}i||""===s?(e.removeClass("hidden"),e.getParent().removeClass("hidden"),t[e.data("cke-emoji-group")]=!0):(e.addClass("hidden"),e.getParent().addClass("hidden"))})),i.forEach(this.elements.sectionHeaders.toArray(),(function(e){t[e.getId()]?(e.getParent().removeClass("hidden"),e.removeClass("hidden")):(e.addClass("hidden"),e.getParent().addClass("hidden"))})),this.refreshNavigationStatus()},clearSearchInput:function(){this.elements.input.setValue(""),this.filter("")},openReset:function(){var e,t=this;return function(){e||(t.filter(""),e=!0),t.elements.emojiBlock.$.scrollTop=0,t.refreshNavigationStatus(),t.clearSearchInput(),CKEDITOR.tools.setTimeout((function(){t.elements.input.focus(!0),t.blockObject._.markItem(t.inputIndex)}),0,t),t.clearStatusbar()}},refreshNavigationStatus:function(){var e,t,s=this.elements.emojiBlock.getClientRect().top;e=i.filter(this.elements.sections.toArray(),(function(e){var t=e.getClientRect();return!(!t.height||e.findOne("h2").hasClass("hidden"))&&t.height+t.top>s})),t=!!e.length&&e[0].data("cke-emoji-group"),i.forEach(this.elements.navigationItems.toArray(),(function(e){e.data("cke-emoji-group")===t?e.addClass("active"):e.removeClass("active")}))},updateStatusbar:function(e){"a"===e.getName()&&e.hasAttribute("data-cke-emoji-name")&&(this.elements.statusIcon.setText(s(e.getText())),this.elements.statusDescription.setText(s(e.data("cke-emoji-name"))),this.elements.statusName.setText(s(e.data("cke-emoji-full-name"))))},clearStatusbar:function(){this.elements.statusIcon.setText(""),this.elements.statusDescription.setText(""),this.elements.statusName.setText("")},clearSearchAndMoveFocus:function(e){this.clearSearchInput(),this.moveFocus(e.data("cke-emoji-group"))},moveFocus:function(e){var t;(e=this.blockElement.findOne('a[data-cke-emoji-group="'+s(e)+'"]'))&&(t=this.getItemIndex(this.items,e),e.focus(!0),e.getAscendant("section").getFirst().scrollIntoView(!0),this.blockObject._.markItem(t))},getItemIndex:function(e,t){return i.indexOf(e.toArray(),(function(e){return e.equals(t)}))},loadSVGNavigationIcons:function(){if(this.editor.plugins.emoji.isSVGSupported()){var e=this.blockElement.getDocument();CKEDITOR.ajax.load(CKEDITOR.getUrl(this.plugin.path+"assets/iconsall.svg"),(function(t){var i=new CKEDITOR.dom.element("div");i.addClass("cke_emoji-navigation_icons"),i.setHtml(t),e.getBody().append(i)}))}},addEmojiToGroups:function(){var e={};i.forEach(this.groups,(function(t){e[t.name]=t.items}),this),i.forEach(this.emojiList,(function(t){e[t.group].push(t)}),this)}}});CKEDITOR.plugins.add("emoji",{requires:"autocomplete,textmatch,ajax,panelbutton,floatpanel",lang:"cs,da,de,de-ch,en,en-au,et,fr,gl,hr,hu,it,nl,pl,pt-br,sk,sr,sr-latn,sv,tr,uk,zh,zh-cn",icons:"emojipanel",hidpi:!0,isSupportedEnvironment:function(){return!CKEDITOR.env.ie||11<=CKEDITOR.env.version},beforeInit:function(){this.isSupportedEnvironment()&&!t&&(CKEDITOR.document.appendStyleSheet(this.path+"skins/default.css"),t=!0)},init:function(t){if(this.isSupportedEnvironment()){var i=CKEDITOR.tools.array;CKEDITOR.ajax.load(CKEDITOR.getUrl(t.config.emoji_emojiListUrl||"plugins/emoji/emoji.json"),(function(s){function n(){t._.emoji.autocomplete=new CKEDITOR.plugins.autocomplete(t,{textTestCallback:function(e){return e.collapsed?CKEDITOR.plugins.textMatch.match(e,o):null},dataCallback:a,itemTemplate:'<li data-id="{id}" class="cke_emoji-suggestion_item"><span>{symbol}</span> {name}</li>',outputTemplate:"{symbol}"})}function o(e,t){var i=e.slice(0,t),s=i.match(new RegExp("(?:\\s|^)(:\\S{"+l+"}\\S*)$"));return s?{start:i.lastIndexOf(s[1]),end:t}:null}function a(t,s){var n=t.query.substr(1).toLowerCase(),o=i.filter(r,(function(e){return-1!==e.id.toLowerCase().indexOf(n)})).sort((function(e,t){var i=!e.id.substr(1).indexOf(n);return i!=!t.id.substr(1).indexOf(n)?i?-1:1:e.id>t.id?1:-1}));s(o=i.map(o,e))}if(null!==s){void 0===t._.emoji&&(t._.emoji={}),void 0===t._.emoji.list&&(t._.emoji.list=JSON.parse(s));var r=t._.emoji.list,l=void 0===t.config.emoji_minChars?2:t.config.emoji_minChars;"ready"!==t.status?t.once("instanceReady",n):n()}})),t.addCommand("insertEmoji",{exec:function(e,t){e.insertHtml(t.emojiText)}}),t.plugins.toolbar&&new n(t,this)}},isSVGSupported:function(){return!CKEDITOR.env.ie||CKEDITOR.env.edge}})}();