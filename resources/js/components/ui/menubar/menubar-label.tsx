import { cn } from "@/components";
import { Label } from "@radix-ui/react-menubar";

export type MenubarLabelProps = React.ComponentProps<typeof Label> & {
  inset?: boolean;
};

function MenubarLabel({ className, inset, ...props }: MenubarLabelProps) {
  return (
    <Label
      data-slot="menubar-label"
      data-inset={inset}
      className={cn(
        "px-2 py-1.5 text-sm font-medium",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarLabel;
