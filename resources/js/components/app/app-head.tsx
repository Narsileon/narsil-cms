import { Head } from "@inertiajs/react";
import React from "react";

type AppHeadProps = React.ComponentProps<typeof Head> & {
  description?: string;
  index: boolean;
  follow: boolean;
};

function AppHead({
  children,
  description = "",
  follow,
  index,
  title = "",
}: AppHeadProps) {
  return (
    <Head>
      <title>{title}</title>
      <meta name="description" content={description} />
      <meta
        name="robots"
        content={`${index ? "index" : "noindex"}, ${follow ? "follow" : "nofollow"}`}
      />
      {children}
    </Head>
  );
}

export default AppHead;
