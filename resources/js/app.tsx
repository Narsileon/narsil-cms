import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";

import Layout from "./layouts/layout";

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob("./pages/**/*.tsx", { eager: true });

    const page: any = pages[`./pages/${name}.tsx`];

    page.default.layout =
      page.default?.layout ||
      ((page: React.ReactNode) => <Layout children={page} />);

    return page;
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />);
  },
});
