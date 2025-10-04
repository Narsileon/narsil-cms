import { cn } from "@narsil-cms/lib/utils";

type KbdGroupProps = React.ComponentProps<"div">;

function KbdGroup({ className, ...props }: KbdGroupProps) {
  return (
    <kbd
      data-slot="kbd-group"
      className={cn("inline-flex items-center gap-1", className)}
      {...props}
    />
  );
}
export default KbdGroup;
