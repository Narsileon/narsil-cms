import { separatorRootVariants } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";
import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuSeparatorProps = ComponentProps<typeof ContextMenu.Separator>;

function ContextMenuSeparator({ className, ...props }: ContextMenuSeparatorProps) {
  return (
    <ContextMenu.Separator
      data-slot="context-menu-separator"
      className={cn(separatorRootVariants({ variant: "menu" }), className)}
      {...props}
    />
  );
}

export default ContextMenuSeparator;
