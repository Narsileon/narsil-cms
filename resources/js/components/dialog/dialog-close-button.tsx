import { Dialog as DialogPrimitive } from "radix-ui";

import { Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";
import { cn } from "@narsil-cms/lib/utils";

type DialogCloseButtonProps = React.ComponentProps<
  typeof DialogPrimitive.Close
> & {};

function DialogCloseButton({ className, ...props }: DialogCloseButtonProps) {
  const { trans } = useLabels();

  const tooltip = trans("accessibility.close_dialog", "Close dialog");

  return (
    <Tooltip tooltip={tooltip}>
      <DialogPrimitive.Close
        data-slot="dialog-close"
        className={cn(
          "cursor-pointer rounded-full opacity-75 ring-offset-background transition-opacity",
          "disabled:pointer-events-none",
          "focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:outline-hidden",
          "hover:opacity-100",
          "data-[state=open]:bg-accent data-[state=open]:text-muted-foreground",
          "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
          className,
        )}
        {...props}
      >
        <Icon name="x" />
        <VisuallyHiddenRoot>{tooltip}</VisuallyHiddenRoot>
      </DialogPrimitive.Close>
    </Tooltip>
  );
}

export default DialogCloseButton;
