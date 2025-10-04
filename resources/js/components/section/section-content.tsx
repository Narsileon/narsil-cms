import { type ComponentProps } from "react";

type SectionContentProps = ComponentProps<"div">;

function SectionContent({ ...props }: SectionContentProps) {
  return <div data-slot="section-content" {...props} />;
}

export default SectionContent;
