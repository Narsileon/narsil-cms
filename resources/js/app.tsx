import { createInertiaApp } from "@inertiajs/react";
import Layout from "@narsil-cms/layouts/layout";
import { type ComponentProps } from "react";
import { createRoot } from "react-dom/client";

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob("./pages/**/*.tsx", { eager: true });

    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const page: any = pages[`./pages/${name}.tsx`];

    page.default.layout =
      page.default?.layout ||
      ((page: ComponentProps<typeof Layout>["children"]) => <Layout children={page} />);

    return page;
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />);
  },
});
