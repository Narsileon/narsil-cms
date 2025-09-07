import { Head as HeadPrimitive } from "@inertiajs/react";
import React from "react";

type HeadProps = React.ComponentProps<typeof HeadPrimitive> & {
  description?: string;
  index: boolean;
  follow: boolean;
};

function Head({
  children,
  description = "",
  follow,
  index,
  title = "",
}: HeadProps) {
  return (
    <HeadPrimitive>
      <title>{title}</title>
      <meta name="description" content={description} />
      <meta
        name="robots"
        content={`${index ? "index" : "noindex"}, ${follow ? "follow" : "nofollow"}`}
      />
      {children}
    </HeadPrimitive>
  );
}

export default Head;
