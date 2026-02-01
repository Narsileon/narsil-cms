import { mergeProps, useRender } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";

function SidebarGroupLabel({ className, render, ...props }: useRender.ComponentProps<"div">) {
  return useRender({
    defaultTagName: "div",

    props: mergeProps<"div">(
      {
        className: cn(
          "flex h-8 shrink-0 items-center rounded-md bg-linear-to-r from-transparent to-transparent px-2 text-xs font-medium text-muted-foreground ring-sidebar-ring outline-hidden transition-[margin,opacity] duration-300 ease-linear",
          "focus-visible:ring-2",
          "[&>svg]:size-4 [&>svg]:shrink-0",
          "group-data-[collapsible=icon]:-z-10 group-data-[collapsible=icon]:-mt-8 group-data-[collapsible=icon]:opacity-0",
          className,
        ),
      },
      props,
    ),
    render: render,
    state: {
      slot: "sidebar-group-label",
      sidebar: "group-label",
    },
  });
}

export default SidebarGroupLabel;
