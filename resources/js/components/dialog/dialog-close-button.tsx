import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/repositories/icons";
import { Dialog } from "radix-ui";
import { type ComponentProps } from "react";

function DialogCloseButton({
  className,
  icon = "x",
  ...props
}: ComponentProps<typeof Dialog.Close> & {
  icon?: IconName;
}) {
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
        <span className="sr-only">{tooltip}</span>
      </Dialog.Close>
    </Tooltip>
  );
}

export default DialogCloseButton;
