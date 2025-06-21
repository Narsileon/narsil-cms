const Ziggy = {"url":"https:\/\/narsil-cms.ddev.site","port":null,"defaults":{},"routes":{"home":{"uri":"\/","methods":["GET","HEAD"]},"settings":{"uri":"settings","methods":["GET","HEAD"]},"sites.index":{"uri":"sites","methods":["GET","HEAD"]},"sites.create":{"uri":"sites\/create","methods":["GET","HEAD"]},"sites.store":{"uri":"sites","methods":["POST"]},"sites.show":{"uri":"sites\/{site}","methods":["GET","HEAD"],"parameters":["site"]},"sites.edit":{"uri":"sites\/{site}\/edit","methods":["GET","HEAD"],"parameters":["site"]},"sites.update":{"uri":"sites\/{site}","methods":["PUT","PATCH"],"parameters":["site"]},"sites.destroy":{"uri":"sites\/{site}","methods":["DELETE"],"parameters":["site"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
