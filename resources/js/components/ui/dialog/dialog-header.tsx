import { cn } from "@narsil-cms/lib/utils";

type DialogHeaderProps = React.ComponentProps<"div"> & {};

function DialogHeader({ className, ...props }: DialogHeaderProps) {
  return (
    <div
      data-slot="dialog-header"
      className={cn(
        "flex flex-col gap-3 px-5 pt-3 text-left [.border-b]:pb-3",
        className,
      )}
      {...props}
    />
  );
}
export default DialogHeader;
