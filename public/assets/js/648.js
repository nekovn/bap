"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[648],{586:(e,t,a)=>{a.d(t,{S:()=>s});var n=a(118),r=a(3907),s=function(){var e=(0,r.oR)();return Object.fromEntries(Object.keys(e.getters).map((function(t){return[t,(0,n.computed)((function(){return e.getters[t]}))]})))}},6648:(e,t,a)=>{a.r(t),a.d(t,{default:()=>i});var n=a(118),r={class:"toast-body navbar"},s=["innerHTML"];var o=a(586),l=a(3907);const c={name:"ToastElement",setup:function(){var e=(0,l.oR)();return{GET_TOAST:(0,o.S)().GET_TOAST,closeToast:function(t){t.preventDefault(),t.stopImmediatePropagation(),e.dispatch("setToast")}}}};const i=(0,a(3744).Z)(c,[["render",function(e,t,a,o,l,c){return(0,n.openBlock)(),(0,n.createElementBlock)("div",{class:(0,n.normalizeClass)(["toast toast-msg",o.GET_TOAST.class]),role:"alert","aria-live":"assertive","aria-atomic":"true"},[(0,n.createElementVNode)("div",r,[(0,n.createElementVNode)("div",{class:"text-white","aria-label":"alert-title",innerHTML:o.GET_TOAST.content},null,8,s),(0,n.createElementVNode)("button",{type:"button",class:"ms-2 btn-close","aria-label":"Close",onClick:t[0]||(t[0]=function(){return o.closeToast&&o.closeToast.apply(o,arguments)})})])],2)}]])}}]);
//# sourceMappingURL=648.js.map