import { ContextMenu } from "radix-ui";

import { separatorRootVariants } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";

type ContextMenuSeparatorProps = React.ComponentProps<
  typeof ContextMenu.Separator
> & {};

function ContextMenuSeparator({
  className,
  ...props
}: ContextMenuSeparatorProps) {
  return (
    <ContextMenu.Separator
      data-slot="context-menu-separator"
      className={cn(separatorRootVariants({ variant: "menu" }), className)}
      {...props}
    />
  );
}

export default ContextMenuSeparator;
