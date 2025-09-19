import { cn } from "@narsil-cms/lib/utils";

type CommandInputWrapperProps = React.ComponentProps<"div"> & {};

function CommandInputWrapper({
  className,
  ...props
}: CommandInputWrapperProps) {
  return (
    <div
      data-slot="command-input-wrapper"
      className={cn("flex h-9 items-center gap-2 border-b px-3", className)}
      {...props}
    />
  );
}

export default CommandInputWrapper;
