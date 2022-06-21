"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[138],{3860:(e,t)=>{t.Z=(e,t)=>{const r=e.__vccOpts||e;for(const[e,n]of t)r[e]=n;return r}},1390:(e,t,r)=>{r.d(t,{Z:()=>s});var n=r(6521),o=["type"];const s={__name:"Button",props:{type:{type:String,default:"submit"}},setup:function(e){return function(t,r){return(0,n.openBlock)(),(0,n.createElementBlock)("button",{type:e.type,class:"inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"},[(0,n.renderSlot)(t.$slots,"default")],8,o)}}}},9355:(e,t,r)=>{r.d(t,{Z:()=>u});var n=r(6521),o=r(5050),s={class:"md:grid md:grid-cols-3 md:gap-6"},a={class:"mt-5 md:mt-0 md:col-span-2"},l={class:"grid grid-cols-6 gap-6"},c={key:0,class:"flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"};const u={__name:"FormSection",emits:["submitted"],setup:function(e){var t=(0,n.computed)((function(){return!!(0,n.useSlots)().actions}));return function(e,r){return(0,n.openBlock)(),(0,n.createElementBlock)("div",s,[(0,n.createVNode)(o.Z,null,{title:(0,n.withCtx)((function(){return[(0,n.renderSlot)(e.$slots,"title")]})),description:(0,n.withCtx)((function(){return[(0,n.renderSlot)(e.$slots,"description")]})),_:3}),(0,n.createElementVNode)("div",a,[(0,n.createElementVNode)("form",{onSubmit:r[0]||(r[0]=(0,n.withModifiers)((function(t){return e.$emit("submitted")}),["prevent"]))},[(0,n.createElementVNode)("div",{class:(0,n.normalizeClass)(["px-4 py-5 bg-white sm:p-6 shadow",(0,n.unref)(t)?"sm:rounded-tl-md sm:rounded-tr-md":"sm:rounded-md"])},[(0,n.createElementVNode)("div",l,[(0,n.renderSlot)(e.$slots,"form")])],2),(0,n.unref)(t)?((0,n.openBlock)(),(0,n.createElementBlock)("div",c,[(0,n.renderSlot)(e.$slots,"actions")])):(0,n.createCommentVNode)("",!0)],32)])])}}}},7089:(e,t,r)=>{r.d(t,{Z:()=>s});var n=r(6521),o=["value"];const s={__name:"Input",props:{modelValue:String},emits:["update:modelValue"],setup:function(e,t){var r=t.expose,s=(0,n.ref)(null);return(0,n.onMounted)((function(){s.value.hasAttribute("autofocus")&&s.value.focus()})),r({focus:function(){return s.value.focus()}}),function(t,r){return(0,n.openBlock)(),(0,n.createElementBlock)("input",{ref_key:"input",ref:s,class:"border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm",value:e.modelValue,onInput:r[0]||(r[0]=function(e){return t.$emit("update:modelValue",e.target.value)})},null,40,o)}}}},3277:(e,t,r)=>{r.d(t,{Z:()=>s});var n=r(6521),o={class:"text-sm text-red-600"};const s={__name:"InputError",props:{message:String},setup:function(e){return function(t,r){return(0,n.withDirectives)(((0,n.openBlock)(),(0,n.createElementBlock)("div",null,[(0,n.createElementVNode)("p",o,(0,n.toDisplayString)(e.message),1)],512)),[[n.vShow,e.message]])}}}},4091:(e,t,r)=>{r.d(t,{Z:()=>l});var n=r(6521),o={class:"block font-medium text-sm text-gray-700"},s={key:0},a={key:1};const l={__name:"Label",props:{value:String},setup:function(e){return function(t,r){return(0,n.openBlock)(),(0,n.createElementBlock)("label",o,[e.value?((0,n.openBlock)(),(0,n.createElementBlock)("span",s,(0,n.toDisplayString)(e.value),1)):((0,n.openBlock)(),(0,n.createElementBlock)("span",a,[(0,n.renderSlot)(t.$slots,"default")]))])}}}},5050:(e,t,r)=>{r.d(t,{Z:()=>i});var n=r(6521),o={class:"md:col-span-1 flex justify-between"},s={class:"px-4 sm:px-0"},a={class:"text-lg font-medium text-gray-900"},l={class:"mt-1 text-sm text-gray-600"},c={class:"px-4 sm:px-0"};const u={},i=(0,r(3860).Z)(u,[["render",function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)("div",o,[(0,n.createElementVNode)("div",s,[(0,n.createElementVNode)("h3",a,[(0,n.renderSlot)(e.$slots,"title")]),(0,n.createElementVNode)("p",l,[(0,n.renderSlot)(e.$slots,"description")])]),(0,n.createElementVNode)("div",c,[(0,n.renderSlot)(e.$slots,"aside")])])}]])},4138:(e,t,r)=>{r.r(t),r.d(t,{default:()=>V});var n=r(6521),o=r(4896),s=r(1390),a=r(9355),l=r(7089),c=r(3277),u=r(4091),i=(0,n.createTextVNode)(" Team Details "),d=(0,n.createTextVNode)(" Create a new team to collaborate with others on projects. "),m={class:"col-span-6"},p={class:"flex items-center mt-2"},f=["src","alt"],g={class:"ml-4 leading-tight"},v={class:"text-sm text-gray-700"},x={class:"col-span-6 sm:col-span-4"},y=(0,n.createTextVNode)(" Create ");const V={__name:"CreateTeamForm",setup:function(e){var t=(0,o.cI)({name:""}),r=function(){t.post(route("teams.store"),{errorBag:"createTeam",preserveScroll:!0})};return function(e,o){return(0,n.openBlock)(),(0,n.createBlock)(a.Z,{onSubmitted:r},{title:(0,n.withCtx)((function(){return[i]})),description:(0,n.withCtx)((function(){return[d]})),form:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",m,[(0,n.createVNode)(u.Z,{value:"Team Owner"}),(0,n.createElementVNode)("div",p,[(0,n.createElementVNode)("img",{class:"object-cover w-12 h-12 rounded-full",src:e.$page.props.user.profile_photo_url,alt:e.$page.props.user.name},null,8,f),(0,n.createElementVNode)("div",g,[(0,n.createElementVNode)("div",null,(0,n.toDisplayString)(e.$page.props.user.name),1),(0,n.createElementVNode)("div",v,(0,n.toDisplayString)(e.$page.props.user.email),1)])])]),(0,n.createElementVNode)("div",x,[(0,n.createVNode)(u.Z,{for:"name",value:"Team Name"}),(0,n.createVNode)(l.Z,{id:"name",modelValue:(0,n.unref)(t).name,"onUpdate:modelValue":o[0]||(o[0]=function(e){return(0,n.unref)(t).name=e}),type:"text",class:"block w-full mt-1",autofocus:""},null,8,["modelValue"]),(0,n.createVNode)(c.Z,{message:(0,n.unref)(t).errors.name,class:"mt-2"},null,8,["message"])])]})),actions:(0,n.withCtx)((function(){return[(0,n.createVNode)(s.Z,{class:(0,n.normalizeClass)({"opacity-25":(0,n.unref)(t).processing}),disabled:(0,n.unref)(t).processing},{default:(0,n.withCtx)((function(){return[y]})),_:1},8,["class","disabled"])]})),_:1})}}}}}]);