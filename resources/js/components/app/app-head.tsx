import { Head } from "@inertiajs/react";
import { useProps } from "@narsil-cms/hooks/use-props";
import React from "react";

type AppHeadProps = React.ComponentProps<typeof Head> & {
  description?: string;
  index: boolean;
  follow: boolean;
};

function AppHead({
  children,
  description,
  follow,
  index,
  title,
}: AppHeadProps) {
  const pageProps = useProps();

  return (
    <Head>
      <title>{pageProps.title ?? title ?? ""}</title>
      <meta
        name="description"
        content={pageProps.description ?? description ?? ""}
      />
      <meta
        name="robots"
        content={`${index ? "index" : "noindex"}, ${follow ? "follow" : "nofollow"}`}
      />
      {children}
    </Head>
  );
}

export default AppHead;
