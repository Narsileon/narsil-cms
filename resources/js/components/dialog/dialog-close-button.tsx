import { Tooltip, VisuallyHidden } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/repositories/icons";
import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

type DialogCloseButtonProps = ComponentProps<typeof Dialog.Close> & {
  icon?: IconName;
};

function DialogCloseButton({ className, icon = "x", ...props }: DialogCloseButtonProps) {
  const { trans } = useLocalization();

  const tooltip = trans("accessibility.close_dialog");

  return (
    <Tooltip tooltip={tooltip}>
      <Dialog.Close
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
        <Icon name={icon} />
        <VisuallyHidden>{tooltip}</VisuallyHidden>
      </Dialog.Close>
    </Tooltip>
  );
}

export default DialogCloseButton;
