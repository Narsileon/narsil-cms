import { cn } from "@narsil-cms/lib/utils";
import { Command } from "cmdk";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from "@narsil-cms/components/ui/dialog";

type CommandDialogProps = React.ComponentProps<typeof Dialog> & {
  className?: string;
  description?: string;
  showCloseButton?: boolean;
  title?: string;
};

function CommandDialog({
  title = "Command list",
  description = "Search for a command to run...",
  children,
  className,
  showCloseButton = true,
  ...props
}: CommandDialogProps) {
  return (
    <Dialog {...props}>
      <VisuallyHidden>
        <DialogHeader>
          <DialogTitle>{title}</DialogTitle>
          <DialogDescription>{description}</DialogDescription>
        </DialogHeader>
      </VisuallyHidden>
      <DialogContent
        className={cn("overflow-hidden p-0", className)}
        showCloseButton={showCloseButton}
      >
        <Command
          className={cn(
            "[&_[cmdk-group-heading]]:text-muted-foreground [&_[cmdk-group-heading]]:px-2 [&_[cmdk-group-heading]]:font-medium",
            "[&_[cmdk-group]]:px-2 [&_[cmdk-group]:not([hidden])_~[cmdk-group]]:pt-0",
            "[&_[cmdk-input-wrapper]_svg]:h-5 [&_[cmdk-input-wrapper]_svg]:w-5",
            "[&_[cmdk-input]]:h-12",
            "[&_[cmdk-item]]:px-2 [&_[cmdk-item]]:py-3 [&_[cmdk-item]_svg]:h-5 [&_[cmdk-item]_svg]:w-5",
            "**:data-[slot=command-input-wrapper]:h-12",
          )}
        >
          {children}
        </Command>
      </DialogContent>
    </Dialog>
  );
}

export default CommandDialog;
