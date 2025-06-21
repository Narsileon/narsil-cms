import { cn } from "@/lib/utils";

export type DialogHeaderProps = React.ComponentProps<"div"> & {};

function DialogHeader({ className, ...props }: DialogHeaderProps) {
  return (
    <div
      data-slot="dialog-header"
      className={cn("flex flex-col gap-2 text-center sm:text-left", className)}
      {...props}
    />
  );
}
export default DialogHeader;
