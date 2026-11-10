# Build status - SIB 2026 final project

Updated 2026-11-10. This records what actually runs and what was verified, not
what is planned. The official calendar (20 Nov - 18 Dec 2026 work, 16-18 Dec
rehearsal, 21-23 Dec assessment) is unchanged.

## Environment

| Component | Value |
| --- | --- |
| OS | Windows 11 Pro |
| Host RAM | 7.8 GB (representative 8 GB laptop) |
| PowerShell | 5.1.26100 |
| Git for Windows | 2.56.0 (+ Git Bash 5.3.15) |
| PHP | 8.2.4 (XAMPP), `pdo_sqlite`, `curl`, `zip` |
| Python | not installed (Store alias only); not required |
| Docker | not installed; not required for the current build |

No Python-dependent bootstrap is needed. Spec Kit scripts can still run under
Git Bash; `scripts/select-feature.ps1` replaces the Python feature selector in
each lab repository.

## Repositories

| Repository | State |
| --- | --- |
| planning (this repo) | DFIR and GRC packages added |
| `vapt-labs/` | 3 of 3 targets implemented and packaged |
| `soc-labs/` | 3 of 3 cases implemented and packaged |
| `devsecops-labs/` | 2 of 2 cases implemented and packaged |

`.specify/feature.json` is set in each lab repository and is intentionally
gitignored machine-local state.

## Theme status

| Theme | Implementation | Key verification |
| --- | --- | --- |
| VAPT | KampusMart, PerpusDigital, EventPass; vulnerable + patched | 29/29, 24-25/25, 25/25 checks; packages verify with zero hash mismatches |
| DFIR | 3 static evidence packages + separate mentor keys | manifests 0 mismatches; 51/51 integrity checks; 36/36 Q1-Q12 coverage |
| SOC | 3 datasets + replay/query/evaluate/freeze/package harness | SOC-1 8/0/13/28 and 7/0/9/11; SOC-2 3/0/2/19 both; SOC-3 12/0/2/12 both |
| GRC/BCP | 2 tabletops with staged injects, templates, mentor ranges | manifests 0 mismatches; both answer keys parse; legal articles checked on official JDIH pages |
| DevSecOps | CampusAPI release gate; BuildGate provenance | DEV-1 13/13 verifications; DEV-2 12/12 verifications |

Metric order is TP/FP/FN/TN.

## Measured VAPT footprint

- PHP process working set: 22.0 MB; private bytes 9.6 MB.
- Start to healthy: under 3 seconds.
- Package size: about 0.1 MB per target.
- Listen address: `127.0.0.1` only (verified with `Get-NetTCPConnection`).
- Reset restored seeded orders, coupons, markers, and an empty evidence log.
- Packaging prunes instructor tests and regenerates the manifest; all three
  packages verify with zero mismatches.

## Public / private separation

- Instructor keys live in `instructor-private/` and are gitignored:
  DFIR mentor keys, GRC answer ranges, SOC holdout labels and reference rules,
  DevSecOps golden artifacts and expected outcomes.
- Participant packages contain one case only. Automated release checks confirmed
  no holdout labels, reference rules, golden artifacts, expected outcomes, or
  e2e tests in the shipped zips.
- VAPT packages are grey-box because PHP ships as source; grading requires a
  reproducible request and evidence ID, not a marker value alone.

## Remaining work (honest)

1. Blind pilot on representative student laptops for all five themes; measure
   time-to-proof, confusion points, RAM, and disk.
2. Cross-target difficulty calibration for VAPT and cross-case calibration for
   SOC.
3. SOC Sigma mapping note where Sigma semantics fit.
4. DEV-2 cryptographic signing-key simulation (current trust root is a local
   builder identity).
5. DFIR decision on binary artifacts (EVTX/PCAP/image) versus the current
   JSON/CSV exports; today the packages teach analysis without forensic tools.
6. GRC re-check of the status of PP 71/2019 and the Lembaga PDP before release;
   both are flagged in the packages.
7. Remote/mentor-hosted fallback for devices that fail the local pilot.
8. Blind review of student-facing cards and rubric scoring.

## Verify locally

```powershell
# VAPT
cd vapt-labs
.\tools\lab.ps1 -Action build -Target kampusmart -Variant vulnerable
.\tools\lab.ps1 -Action test  -Target kampusmart -Variant vulnerable -Port 8081

# SOC
cd ..\soc-labs
.\tools\soc.ps1 -Action selfcheck -Case soc-1

# DevSecOps
cd ..\devsecops-labs\instructor-private\dev-1
.\verify.ps1

# DFIR
cd ..\..\dfir-cases
php tools\verify.php

# GRC manifests
cd ..\grc-tabletops\01-konseling
Get-Content manifest-sha256.txt
```

## Commit state

Lab repositories have local milestone commits per theme. This planning repository
has the DFIR and GRC packages. Nothing was pushed; no force push was used.
