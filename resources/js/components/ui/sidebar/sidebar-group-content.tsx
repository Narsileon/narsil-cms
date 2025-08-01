import { cn } from "@narsil-cms/lib/utils";

type SidebarGroupContentProps = React.ComponentProps<"div"> & {};

function SidebarGroupContent({
  className,
  ...props
}: SidebarGroupContentProps) {
  return (
    <div
      data-slot="sidebar-group-content"
      data-sidebar="group-content"
      className={cn("flex w-full flex-col gap-1 text-sm", className)}
      {...props}
    />
  );
}

export default SidebarGroupContent;
