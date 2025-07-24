import { cn } from "@narsil-cms/lib/utils";

type DialogHeaderProps = React.ComponentProps<"div"> & {};

function DialogHeader({ className, ...props }: DialogHeaderProps) {
  return (
    <div
      data-slot="dialog-header"
      className={cn("flex flex-col gap-3 text-center sm:text-left", className)}
      {...props}
    />
  );
}
export default DialogHeader;
