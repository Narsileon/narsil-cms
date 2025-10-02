import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

import { Tooltip, VisuallyHidden } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type DialogCloseButtonProps = ComponentProps<typeof Dialog.Close> & {
  icon?: IconName;
};

function DialogCloseButton({
  className,
  icon = "x",
  ...props
}: DialogCloseButtonProps) {
  const { trans } = useLabels();

  const tooltip = trans("accessibility.close_dialog", "Close dialog");

  return (
    <Tooltip tooltip={tooltip}>
      <Dialog.Close
        data-slot="dialog-close"
        className={cn(
          "ring-offset-background cursor-pointer rounded-full opacity-75 transition-opacity",
          "disabled:pointer-events-none",
          "focus:ring-ring focus:outline-hidden focus:ring-2 focus:ring-offset-2",
          "hover:opacity-100",
          "data-[state=open]:bg-accent data-[state=open]:text-muted-foreground",
          "[&_svg:not([class*='size-'])]:size-4 [&_svg]:pointer-events-none [&_svg]:shrink-0",
          className,
        )}
        {...props}
      >
        <Icon name={icon} />
        <VisuallyHidden>{tooltip}</VisuallyHidden>
      </Dialog.Close>
    </Tooltip>
  );
}

export default DialogCloseButton;
