import { Head as InertiaHead } from "@inertiajs/react";
import { type ComponentProps } from "react";

type HeadProps = ComponentProps<typeof InertiaHead> & {
  description?: string;
  index: boolean;
  follow: boolean;
};

function Head({
  children,
  description = "",
  follow = false,
  index = false,
  title = "",
}: HeadProps) {
  return (
    <InertiaHead>
      <title>{title}</title>
      <meta name="description" content={description} />
      <meta
        name="robots"
        content={`${index ? "index" : "noindex"}, ${follow ? "follow" : "nofollow"}`}
      />
      {children}
    </InertiaHead>
  );
}

export default Head;
