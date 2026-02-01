import { mergeProps, useRender } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function BreadcrumbLink({ className, render, ...props }: useRender.ComponentProps<"a">) {
  return useRender({
    defaultTagName: "a",
    props: mergeProps<"a">(
      {
        className: cn("transition-colors hover:text-foreground", className),
      },
      props,
    ),
    render: render,
    state: {
      slot: "breadcrumb-link",
    },
  });
}

export default BreadcrumbLink;
