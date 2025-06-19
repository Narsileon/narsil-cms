import { cn } from "@/Components";
import { Root } from "@radix-ui/react-separator";

export type SeparatorProps = React.ComponentProps<typeof Root> & {};

function Separator({
  className,
  decorative = true,
  orientation = "horizontal",
  ...props
}: SeparatorProps) {
  return (
    <Root
      data-slot="separator"
      className={cn(
        "bg-border shrink-0",
        "data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:w-px",
        className,
      )}
      decorative={decorative}
      orientation={orientation}
      {...props}
    />
  );
}

export default Separator;
